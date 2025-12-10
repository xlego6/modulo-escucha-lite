#!/usr/bin/env python3
"""
Servicio de transcripcion para modulo-escucha-lite
Basado en WhisperX con soporte para GPU/CUDA y diarizacion

Uso:
    python transcription_service.py --mode api --port 5000
    python transcription_service.py --mode single --input archivo.mp3 --output resultado.json
"""

import os
import sys
import json
import argparse
import gc
from pathlib import Path
from datetime import datetime
from typing import Optional, Dict, List
from flask import Flask, request, jsonify
import threading
import queue

# Verificar dependencias
try:
    import torch
    import whisperx
    WHISPERX_AVAILABLE = True
except ImportError:
    WHISPERX_AVAILABLE = False
    print("ADVERTENCIA: WhisperX no disponible. Instalar con: pip install whisperx")

# Cache global para modelos
_model_cache = {}
_diarize_model_cache = {}

app = Flask(__name__)

# Cola de trabajos para procesamiento asincrono
job_queue = queue.Queue()
job_status = {}


class TranscriptionService:
    """Servicio de transcripcion usando WhisperX"""

    AUDIO_EXTENSIONS = {'.mp3', '.wav', '.m4a', '.flac', '.ogg', '.opus', '.wma', '.aac'}

    def __init__(
        self,
        model_name: str = "large-v2",
        device: str = "cuda",
        compute_type: str = "float16",
        batch_size: int = 16,
        language: Optional[str] = "es",
        hf_token: Optional[str] = None
    ):
        self.model_name = model_name
        self.device = device if torch.cuda.is_available() else "cpu"
        self.compute_type = compute_type if self.device == "cuda" else "float32"
        self.batch_size = batch_size
        self.language = language
        self.hf_token = hf_token
        self.model = None

    def load_model(self):
        """Carga el modelo de Whisper (lazy loading)"""
        global _model_cache

        cache_key = (self.model_name, self.device, self.compute_type)
        if cache_key in _model_cache:
            self.model = _model_cache[cache_key]
            return

        print(f"Cargando modelo Whisper '{self.model_name}'...")
        self.model = whisperx.load_model(
            self.model_name,
            self.device,
            compute_type=self.compute_type
        )
        _model_cache[cache_key] = self.model

    def transcribe(self, audio_path: str, with_diarization: bool = True) -> Dict:
        """
        Transcribe un archivo de audio

        Args:
            audio_path: Ruta al archivo de audio
            with_diarization: Si incluir diarizacion de hablantes

        Returns:
            Diccionario con resultados
        """
        if not WHISPERX_AVAILABLE:
            return {
                "success": False,
                "error": "WhisperX no esta instalado"
            }

        if self.model is None:
            self.load_model()

        audio_path = Path(audio_path)
        if not audio_path.exists():
            return {
                "success": False,
                "error": f"Archivo no encontrado: {audio_path}"
            }

        try:
            # Cargar audio
            audio = whisperx.load_audio(str(audio_path))

            # Transcripcion inicial
            result = self.model.transcribe(
                audio,
                batch_size=self.batch_size,
                language=self.language
            )

            detected_language = result.get("language", self.language or "unknown")

            # Alineacion de timestamps
            model_a, metadata = whisperx.load_align_model(
                language_code=detected_language,
                device=self.device
            )
            result = whisperx.align(
                result["segments"],
                model_a,
                metadata,
                audio,
                self.device,
                return_char_alignments=False
            )

            # Limpiar memoria
            gc.collect()
            if torch.cuda.is_available():
                torch.cuda.empty_cache()
            del model_a

            # Diarizacion opcional
            speakers_count = 0
            if with_diarization and self.hf_token:
                result, speakers_count = self._apply_diarization(audio, result)

            # Generar texto formateado
            formatted_text = self._format_text(result)

            # Limpiar
            del audio
            gc.collect()
            if torch.cuda.is_available():
                torch.cuda.empty_cache()

            return {
                "success": True,
                "audio_file": str(audio_path),
                "language": detected_language,
                "text": formatted_text,
                "segments": result["segments"],
                "speakers_count": speakers_count,
                "has_diarization": with_diarization and self.hf_token is not None,
                "processed_at": datetime.now().isoformat()
            }

        except Exception as e:
            return {
                "success": False,
                "error": str(e),
                "audio_file": str(audio_path)
            }

    def _apply_diarization(self, audio, result) -> tuple:
        """Aplica diarizacion de hablantes"""
        global _diarize_model_cache

        try:
            from pyannote.audio import Pipeline

            cache_key = (self.device, self.hf_token)
            if cache_key in _diarize_model_cache:
                diarize_model = _diarize_model_cache[cache_key]
            else:
                diarize_model = Pipeline.from_pretrained(
                    "pyannote/speaker-diarization-3.1",
                    use_auth_token=self.hf_token
                )
                diarize_model.to(torch.device(self.device))
                _diarize_model_cache[cache_key] = diarize_model

            # Preparar audio para pyannote
            audio_data = {
                'waveform': torch.from_numpy(audio[None, :]),
                'sample_rate': whisperx.audio.SAMPLE_RATE
            }

            diarize_segments = diarize_model(audio_data)
            result = whisperx.assign_word_speakers(diarize_segments, result)

            # Contar hablantes
            speakers = set()
            for seg in result['segments']:
                if 'speaker' in seg:
                    speakers.add(seg['speaker'])

            gc.collect()
            if torch.cuda.is_available():
                torch.cuda.empty_cache()

            return result, len(speakers)

        except Exception as e:
            print(f"Error en diarizacion: {e}")
            return result, 0

    def _format_text(self, result) -> str:
        """Formatea el texto con separacion de hablantes"""
        if not result.get('segments'):
            return ""

        segments = result['segments']
        first_segment = segments[0]
        current_speaker = first_segment.get('speaker', '')

        if current_speaker:
            formatted = f"[{current_speaker.replace('SPEAKER_', 'HABLANTE_')}]\n{first_segment['text'].strip()}"
        else:
            formatted = first_segment['text'].strip()

        for seg in segments[1:]:
            text = seg['text'].strip()
            if not text:
                continue

            speaker = seg.get('speaker', '')
            if speaker and speaker != current_speaker:
                current_speaker = speaker
                formatted += f"\n\n[{speaker.replace('SPEAKER_', 'HABLANTE_')}]\n{text}"
            else:
                formatted += f" {text}"

        return formatted

    def get_status(self) -> Dict:
        """Retorna el estado del servicio"""
        gpu_info = {}
        if torch.cuda.is_available():
            gpu_info = {
                "name": torch.cuda.get_device_name(0),
                "memory_allocated": f"{torch.cuda.memory_allocated(0) / 1024**3:.2f} GB",
                "memory_total": f"{torch.cuda.get_device_properties(0).total_memory / 1024**3:.2f} GB"
            }

        return {
            "whisperx_available": WHISPERX_AVAILABLE,
            "device": self.device,
            "model": self.model_name,
            "model_loaded": self.model is not None,
            "gpu": gpu_info,
            "diarization_enabled": self.hf_token is not None
        }


# Instancia global del servicio
service = None


def get_service():
    """Obtiene o crea la instancia del servicio"""
    global service
    if service is None:
        service = TranscriptionService(
            model_name=os.environ.get('WHISPER_MODEL', 'large-v2'),
            language=os.environ.get('WHISPER_LANGUAGE', 'es'),
            hf_token=os.environ.get('HF_TOKEN')
        )
    return service


# ============ API REST ============

@app.route('/status', methods=['GET'])
def api_status():
    """Estado del servicio"""
    svc = get_service()
    return jsonify(svc.get_status())


@app.route('/transcribe', methods=['POST'])
def api_transcribe():
    """
    Transcribe un archivo de audio

    Body JSON:
        audio_path: Ruta al archivo de audio
        with_diarization: bool (opcional, default True)

    Returns:
        Resultado de la transcripcion
    """
    data = request.get_json()
    if not data or 'audio_path' not in data:
        return jsonify({"success": False, "error": "audio_path requerido"}), 400

    svc = get_service()
    result = svc.transcribe(
        data['audio_path'],
        with_diarization=data.get('with_diarization', True)
    )

    if result['success']:
        return jsonify(result)
    else:
        return jsonify(result), 500


@app.route('/transcribe/async', methods=['POST'])
def api_transcribe_async():
    """
    Inicia una transcripcion asincrona

    Body JSON:
        audio_path: Ruta al archivo de audio
        job_id: ID unico del trabajo
        with_diarization: bool (opcional)

    Returns:
        job_id para consultar estado
    """
    data = request.get_json()
    if not data or 'audio_path' not in data:
        return jsonify({"success": False, "error": "audio_path requerido"}), 400

    job_id = data.get('job_id', datetime.now().strftime('%Y%m%d_%H%M%S_%f'))

    job_status[job_id] = {
        "status": "queued",
        "audio_path": data['audio_path'],
        "created_at": datetime.now().isoformat()
    }

    job_queue.put({
        "job_id": job_id,
        "audio_path": data['audio_path'],
        "with_diarization": data.get('with_diarization', True)
    })

    return jsonify({
        "success": True,
        "job_id": job_id,
        "status": "queued"
    })


@app.route('/job/<job_id>', methods=['GET'])
def api_job_status(job_id):
    """Consulta el estado de un trabajo"""
    if job_id not in job_status:
        return jsonify({"success": False, "error": "Job no encontrado"}), 404

    return jsonify(job_status[job_id])


def process_job_queue():
    """Worker para procesar la cola de trabajos"""
    while True:
        try:
            job = job_queue.get(timeout=1)
            job_id = job['job_id']

            job_status[job_id]['status'] = 'processing'
            job_status[job_id]['started_at'] = datetime.now().isoformat()

            svc = get_service()
            result = svc.transcribe(
                job['audio_path'],
                with_diarization=job.get('with_diarization', True)
            )

            job_status[job_id].update(result)
            job_status[job_id]['status'] = 'completed' if result['success'] else 'failed'
            job_status[job_id]['completed_at'] = datetime.now().isoformat()

        except queue.Empty:
            continue
        except Exception as e:
            if 'job_id' in locals():
                job_status[job_id]['status'] = 'failed'
                job_status[job_id]['error'] = str(e)


# ============ CLI ============

def main():
    parser = argparse.ArgumentParser(description='Servicio de transcripcion')

    parser.add_argument(
        '--mode',
        choices=['api', 'single'],
        default='api',
        help='Modo: api (servidor REST) o single (transcribir un archivo)'
    )

    parser.add_argument('--port', type=int, default=5000, help='Puerto para modo API')
    parser.add_argument('--host', default='0.0.0.0', help='Host para modo API')
    parser.add_argument('--input', '-i', help='Archivo de audio (modo single)')
    parser.add_argument('--output', '-o', help='Archivo de salida JSON (modo single)')
    parser.add_argument('--model', default='large-v2', help='Modelo Whisper')
    parser.add_argument('--language', '-l', default='es', help='Idioma')
    parser.add_argument('--no-diarization', action='store_true', help='Desactivar diarizacion')
    parser.add_argument('--hf-token', help='Token de HuggingFace para diarizacion')

    args = parser.parse_args()

    if args.mode == 'single':
        if not args.input:
            print("Error: --input requerido en modo single")
            sys.exit(1)

        svc = TranscriptionService(
            model_name=args.model,
            language=args.language,
            hf_token=args.hf_token or os.environ.get('HF_TOKEN')
        )

        print(f"Transcribiendo: {args.input}")
        result = svc.transcribe(args.input, with_diarization=not args.no_diarization)

        if args.output:
            with open(args.output, 'w', encoding='utf-8') as f:
                json.dump(result, f, ensure_ascii=False, indent=2)
            print(f"Resultado guardado en: {args.output}")
        else:
            print(json.dumps(result, ensure_ascii=False, indent=2))

    else:  # modo api
        # Iniciar worker de cola en segundo plano
        worker = threading.Thread(target=process_job_queue, daemon=True)
        worker.start()

        print(f"Iniciando servidor API en {args.host}:{args.port}")
        print("Endpoints:")
        print(f"  GET  /status          - Estado del servicio")
        print(f"  POST /transcribe      - Transcribir (sincrono)")
        print(f"  POST /transcribe/async - Transcribir (asincrono)")
        print(f"  GET  /job/<job_id>    - Estado de trabajo")

        app.run(host=args.host, port=args.port, debug=False)


if __name__ == '__main__':
    main()

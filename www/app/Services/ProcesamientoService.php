<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Servicio para conectar con los servicios Python de procesamiento
 * - Transcripcion (WhisperX)
 * - NER (spaCy)
 */
class ProcesamientoService
{
    protected $transcriptionUrl;
    protected $nerUrl;
    protected $timeout;

    public function __construct()
    {
        $this->transcriptionUrl = env('TRANSCRIPTION_SERVICE_URL', 'http://localhost:5000');
        $this->nerUrl = env('NER_SERVICE_URL', 'http://localhost:5001');
        $this->timeout = env('PROCESSING_TIMEOUT', 600); // 10 minutos default
    }

    /**
     * Verifica el estado del servicio de transcripcion
     */
    public function transcriptionStatus(): array
    {
        try {
            $response = Http::timeout(10)->get("{$this->transcriptionUrl}/status");
            return $response->json() ?? ['available' => false];
        } catch (\Exception $e) {
            Log::warning("Servicio de transcripcion no disponible: " . $e->getMessage());
            return [
                'available' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verifica el estado del servicio NER
     */
    public function nerStatus(): array
    {
        try {
            $response = Http::timeout(10)->get("{$this->nerUrl}/status");
            return $response->json() ?? ['available' => false];
        } catch (\Exception $e) {
            Log::warning("Servicio NER no disponible: " . $e->getMessage());
            return [
                'available' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Transcribe un archivo de audio
     *
     * @param string $audioPath Ruta al archivo de audio
     * @param bool $withDiarization Incluir diarizacion de hablantes
     * @return array Resultado de la transcripcion
     */
    public function transcribe(string $audioPath, bool $withDiarization = true): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->transcriptionUrl}/transcribe", [
                    'audio_path' => $audioPath,
                    'with_diarization' => $withDiarization
                ]);

            return $response->json() ?? ['success' => false, 'error' => 'Respuesta vacia'];
        } catch (\Exception $e) {
            Log::error("Error en transcripcion: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Inicia una transcripcion asincrona
     *
     * @param string $audioPath Ruta al archivo de audio
     * @param string $jobId ID unico del trabajo
     * @param bool $withDiarization Incluir diarizacion
     * @return array
     */
    public function transcribeAsync(string $audioPath, string $jobId, bool $withDiarization = true): array
    {
        try {
            $response = Http::timeout(30)
                ->post("{$this->transcriptionUrl}/transcribe/async", [
                    'audio_path' => $audioPath,
                    'job_id' => $jobId,
                    'with_diarization' => $withDiarization
                ]);

            return $response->json() ?? ['success' => false, 'error' => 'Respuesta vacia'];
        } catch (\Exception $e) {
            Log::error("Error iniciando transcripcion asincrona: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Consulta el estado de un trabajo de transcripcion
     *
     * @param string $jobId ID del trabajo
     * @return array
     */
    public function getTranscriptionJob(string $jobId): array
    {
        try {
            $response = Http::timeout(10)
                ->get("{$this->transcriptionUrl}/job/{$jobId}");

            return $response->json() ?? ['success' => false, 'error' => 'Respuesta vacia'];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Detecta entidades en un texto
     *
     * @param string $text Texto a analizar
     * @return array Entidades detectadas
     */
    public function detectEntities(string $text): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->nerUrl}/detect", [
                    'text' => $text
                ]);

            return $response->json() ?? ['success' => false, 'error' => 'Respuesta vacia'];
        } catch (\Exception $e) {
            Log::error("Error en deteccion de entidades: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Anonimiza un texto
     *
     * @param string $text Texto a anonimizar
     * @param array $entityTypes Tipos de entidades a anonimizar
     * @param string $format Formato de reemplazo
     * @return array
     */
    public function anonymize(string $text, array $entityTypes = ['PER', 'LOC'], string $format = 'brackets'): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->nerUrl}/anonymize", [
                    'text' => $text,
                    'entity_types' => $entityTypes,
                    'replacement_format' => $format
                ]);

            return $response->json() ?? ['success' => false, 'error' => 'Respuesta vacia'];
        } catch (\Exception $e) {
            Log::error("Error en anonimizacion: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verifica si todos los servicios estan disponibles
     */
    public function allServicesAvailable(): bool
    {
        $transcription = $this->transcriptionStatus();
        $ner = $this->nerStatus();

        return !isset($transcription['error']) && !isset($ner['error']);
    }

    /**
     * Obtiene informacion de todos los servicios
     */
    public function getServicesInfo(): array
    {
        return [
            'transcription' => $this->transcriptionStatus(),
            'ner' => $this->nerStatus(),
            'urls' => [
                'transcription' => $this->transcriptionUrl,
                'ner' => $this->nerUrl
            ]
        ];
    }
}

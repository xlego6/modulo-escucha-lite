@extends('layouts.app')

@section('title', 'Editar Transcripcion')
@section('content_header')
Editar Transcripcion: {{ $entrevista->entrevista_codigo }}
@endsection

@section('css')
<style>
    #editor-transcripcion {
        min-height: 400px;
        font-family: 'Courier New', monospace;
        font-size: 14px;
        line-height: 1.6;
    }
    .audio-player {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #f4f6f9;
        padding: 10px;
        border-radius: 4px;
    }
    .speaker-tag {
        background: #e9ecef;
        padding: 2px 8px;
        border-radius: 4px;
        font-weight: bold;
        color: #495057;
    }
    .timestamp {
        color: #6c757d;
        font-size: 12px;
    }
</style>
@endsection

@section('content')
<div class="row">
    <!-- Panel de audio -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-headphones mr-2"></i>Reproductor de Audio</h3>
            </div>
            <div class="card-body">
                @php
                    $audios = $entrevista->rel_adjuntos->filter(function($a) {
                        return strpos($a->tipo_mime ?? '', 'audio') !== false;
                    });
                @endphp
                @if($audios->count() > 0)
                    @foreach($audios as $audio)
                    <div class="audio-player mb-3">
                        <p class="mb-1"><strong>{{ $audio->nombre_original }}</strong></p>
                        <audio controls class="w-100" id="audio-{{ $audio->id_adjunto }}">
                            <source src="{{ route('adjuntos.ver', $audio->id_adjunto) }}" type="{{ $audio->tipo_mime }}">
                            Tu navegador no soporta audio HTML5.
                        </audio>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="skipAudio('audio-{{ $audio->id_adjunto }}', -10)">
                                <i class="fas fa-backward"></i> -10s
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="skipAudio('audio-{{ $audio->id_adjunto }}', 10)">
                                +10s <i class="fas fa-forward"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeSpeed('audio-{{ $audio->id_adjunto }}')">
                                <i class="fas fa-tachometer-alt"></i> <span class="speed-label">1x</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-volume-mute fa-2x mb-2"></i>
                        <p>No hay archivos de audio</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Info de la entrevista -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informacion</h3>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Codigo:</dt>
                    <dd class="col-sm-8"><code>{{ $entrevista->entrevista_codigo }}</code></dd>

                    <dt class="col-sm-4">Titulo:</dt>
                    <dd class="col-sm-8">{{ $entrevista->titulo ?: 'Sin titulo' }}</dd>

                    <dt class="col-sm-4">Fecha:</dt>
                    <dd class="col-sm-8">
                        @if($entrevista->fecha_entrevista)
                            {{ \Carbon\Carbon::parse($entrevista->fecha_entrevista)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Atajos de teclado -->
        <div class="card card-secondary collapsed-card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-keyboard mr-2"></i>Atajos de Teclado</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li><kbd>Ctrl</kbd> + <kbd>S</kbd> - Guardar</li>
                    <li><kbd>Ctrl</kbd> + <kbd>Space</kbd> - Play/Pause</li>
                    <li><kbd>Ctrl</kbd> + <kbd>←</kbd> - Retroceder 10s</li>
                    <li><kbd>Ctrl</kbd> + <kbd>→</kbd> - Avanzar 10s</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Editor de transcripción -->
    <div class="col-md-8">
        <form action="{{ route('procesamientos.guardar-transcripcion', $entrevista->id_e_ind_fvt) }}" method="POST" id="form-transcripcion">
            @csrf
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Transcripcion</h3>
                    <div class="card-tools">
                        <span class="badge badge-light" id="char-count">0 caracteres</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <textarea name="transcripcion" id="editor-transcripcion" class="form-control border-0"
                              placeholder="Escriba o pegue la transcripcion aqui...">{{ $entrevista->anotaciones ?? '' }}</textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-primary" onclick="guardarYAprobar()">
                        <i class="fas fa-check-double mr-2"></i>Guardar y Aprobar
                    </button>
                    <a href="{{ route('procesamientos.edicion') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Contador de caracteres
    function updateCharCount() {
        var count = $('#editor-transcripcion').val().length;
        $('#char-count').text(count.toLocaleString() + ' caracteres');
    }
    updateCharCount();
    $('#editor-transcripcion').on('input', updateCharCount);

    // Atajos de teclado
    $(document).on('keydown', function(e) {
        // Ctrl + S - Guardar
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            $('#form-transcripcion').submit();
        }
        // Ctrl + Space - Play/Pause
        if (e.ctrlKey && e.key === ' ') {
            e.preventDefault();
            var audio = $('audio').first()[0];
            if (audio) {
                audio.paused ? audio.play() : audio.pause();
            }
        }
        // Ctrl + Left - Retroceder
        if (e.ctrlKey && e.key === 'ArrowLeft') {
            e.preventDefault();
            var audio = $('audio').first()[0];
            if (audio) audio.currentTime -= 10;
        }
        // Ctrl + Right - Avanzar
        if (e.ctrlKey && e.key === 'ArrowRight') {
            e.preventDefault();
            var audio = $('audio').first()[0];
            if (audio) audio.currentTime += 10;
        }
    });
});

function skipAudio(id, seconds) {
    var audio = document.getElementById(id);
    if (audio) audio.currentTime += seconds;
}

var speeds = [1, 1.25, 1.5, 1.75, 2, 0.75];
var speedIndex = 0;
function changeSpeed(id) {
    speedIndex = (speedIndex + 1) % speeds.length;
    var audio = document.getElementById(id);
    if (audio) {
        audio.playbackRate = speeds[speedIndex];
        $(audio).closest('.audio-player').find('.speed-label').text(speeds[speedIndex] + 'x');
    }
}

function guardarYAprobar() {
    if (confirm('¿Guardar y aprobar esta transcripcion?')) {
        // Primero guardar
        $.ajax({
            url: '{{ route("procesamientos.guardar-transcripcion", $entrevista->id_e_ind_fvt) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                transcripcion: $('#editor-transcripcion').val()
            },
            success: function() {
                // Luego aprobar
                window.location.href = '{{ route("procesamientos.aprobar-transcripcion", $entrevista->id_e_ind_fvt) }}';
            },
            error: function() {
                alert('Error al guardar la transcripcion');
            }
        });
    }
}
</script>
@endsection

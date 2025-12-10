

<?php $__env->startSection('title', 'Editar Transcripcion'); ?>
<?php $__env->startSection('content_header'); ?>
Editar Transcripcion: <?php echo e($entrevista->entrevista_codigo); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Panel de audio -->
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-headphones mr-2"></i>Reproductor de Audio</h3>
            </div>
            <div class="card-body">
                <?php
                    $audios = $entrevista->rel_adjuntos->filter(function($a) {
                        return strpos($a->tipo_mime ?? '', 'audio') !== false;
                    });
                ?>
                <?php if($audios->count() > 0): ?>
                    <?php $__currentLoopData = $audios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $audio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="audio-player mb-3">
                        <p class="mb-1"><strong><?php echo e($audio->nombre_original); ?></strong></p>
                        <audio controls class="w-100" id="audio-<?php echo e($audio->id_adjunto); ?>">
                            <source src="<?php echo e(route('adjuntos.ver', $audio->id_adjunto)); ?>" type="<?php echo e($audio->tipo_mime); ?>">
                            Tu navegador no soporta audio HTML5.
                        </audio>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="skipAudio('audio-<?php echo e($audio->id_adjunto); ?>', -10)">
                                <i class="fas fa-backward"></i> -10s
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="skipAudio('audio-<?php echo e($audio->id_adjunto); ?>', 10)">
                                +10s <i class="fas fa-forward"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeSpeed('audio-<?php echo e($audio->id_adjunto); ?>')">
                                <i class="fas fa-tachometer-alt"></i> <span class="speed-label">1x</span>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <div class="text-center text-muted py-3">
                        <i class="fas fa-volume-mute fa-2x mb-2"></i>
                        <p>No hay archivos de audio</p>
                    </div>
                <?php endif; ?>
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
                    <dd class="col-sm-8"><code><?php echo e($entrevista->entrevista_codigo); ?></code></dd>

                    <dt class="col-sm-4">Titulo:</dt>
                    <dd class="col-sm-8"><?php echo e($entrevista->titulo ?: 'Sin titulo'); ?></dd>

                    <dt class="col-sm-4">Fecha:</dt>
                    <dd class="col-sm-8">
                        <?php if($entrevista->fecha_entrevista): ?>
                            <?php echo e(\Carbon\Carbon::parse($entrevista->fecha_entrevista)->format('d/m/Y')); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
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
        <form action="<?php echo e(route('procesamientos.guardar-transcripcion', $entrevista->id_e_ind_fvt)); ?>" method="POST" id="form-transcripcion">
            <?php echo csrf_field(); ?>
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Transcripcion</h3>
                    <div class="card-tools">
                        <span class="badge badge-light" id="char-count">0 caracteres</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <textarea name="transcripcion" id="editor-transcripcion" class="form-control border-0"
                              placeholder="Escriba o pegue la transcripcion aqui..."><?php echo e($entrevista->anotaciones ?? ''); ?></textarea>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                    <button type="button" class="btn btn-primary" onclick="guardarYAprobar()">
                        <i class="fas fa-check-double mr-2"></i>Guardar y Aprobar
                    </button>
                    <a href="<?php echo e(route('procesamientos.edicion')); ?>" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left mr-2"></i>Volver
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
            url: '<?php echo e(route("procesamientos.guardar-transcripcion", $entrevista->id_e_ind_fvt)); ?>',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                transcripcion: $('#editor-transcripcion').val()
            },
            success: function() {
                // Luego aprobar
                window.location.href = '<?php echo e(route("procesamientos.aprobar-transcripcion", $entrevista->id_e_ind_fvt)); ?>';
            },
            error: function() {
                alert('Error al guardar la transcripcion');
            }
        });
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/procesamientos/editar-transcripcion.blade.php ENDPATH**/ ?>
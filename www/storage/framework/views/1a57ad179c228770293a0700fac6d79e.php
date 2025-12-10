

<?php $__env->startSection('title', 'Transcripcion Automatizada'); ?>
<?php $__env->startSection('content_header', 'Transcripcion Automatizada'); ?>

<?php $__env->startSection('content'); ?>
<!-- Panel de Resultado -->
<div class="row" id="panel-resultado" style="display: none;">
    <div class="col-12">
        <div class="card" id="card-resultado">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-file-alt mr-2"></i>Resultado de Transcripcion</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="$('#panel-resultado').slideUp()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="resultado-loading" class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-3x text-primary mb-3"></i>
                    <h5>Transcribiendo audio...</h5>
                    <p class="text-muted">Este proceso puede tomar varios minutos dependiendo de la duracion del audio.</p>
                    <div class="progress" style="height: 5px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" style="width: 100%"></div>
                    </div>
                </div>
                <div id="resultado-exito" style="display: none;">
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Transcripcion completada exitosamente</strong>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <small class="text-muted">Entrevista:</small><br>
                            <strong id="res-codigo"></strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Caracteres:</small><br>
                            <strong id="res-caracteres"></strong>
                        </div>
                        <div class="col-md-4">
                            <small class="text-muted">Hablantes detectados:</small><br>
                            <strong id="res-hablantes"></strong>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Vista previa del texto:</label>
                        <textarea class="form-control" id="res-texto" rows="8" readonly></textarea>
                    </div>
                    <a href="#" id="btn-editar-transcripcion" class="btn btn-success">
                        <i class="fas fa-edit mr-2"></i>Editar Transcripcion
                    </a>
                </div>
                <div id="resultado-error" style="display: none;">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Error en la transcripcion</strong>
                    </div>
                    <p id="res-error-mensaje" class="text-danger"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info-circle mr-2"></i>WhisperX - Motor de Transcripcion</h5>
            <p class="mb-0">
                Sistema de transcripcion automatica basado en WhisperX con soporte para diarizacion
                (identificacion de hablantes) y marcas de tiempo precisas.
            </p>
        </div>
    </div>
</div>

<?php if($enProceso->count() > 0): ?>
<div class="row">
    <div class="col-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-spinner fa-spin mr-2"></i>En Proceso (<?php echo e($enProceso->count()); ?>)</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Archivos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $enProceso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><code><?php echo e($ent->entrevista_codigo); ?></code></td>
                            <td><?php echo e(\Illuminate\Support\Str::limit($ent->titulo, 40)); ?></td>
                            <td><?php echo e($ent->rel_adjuntos->count()); ?> archivo(s)</td>
                            <td>
                                <span class="badge badge-warning">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Procesando
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-secondary" disabled>
                                    <i class="fas fa-clock"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Entrevistas Pendientes de Transcripcion</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Audios</th>
                            <th>Duracion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $entrevistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input check-item"
                                           id="check<?php echo e($entrevista->id_e_ind_fvt); ?>"
                                           value="<?php echo e($entrevista->id_e_ind_fvt); ?>">
                                    <label class="custom-control-label" for="check<?php echo e($entrevista->id_e_ind_fvt); ?>"></label>
                                </div>
                            </td>
                            <td><code><?php echo e($entrevista->entrevista_codigo); ?></code></td>
                            <td>
                                <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>">
                                    <?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 35)); ?>

                                </a>
                            </td>
                            <td>
                                <span class="badge badge-info"><?php echo e($entrevista->rel_adjuntos->count()); ?></span>
                            </td>
                            <td>
                                <?php
                                    $duracion = $entrevista->rel_adjuntos->sum('duracion');
                                    $horas = floor($duracion / 3600);
                                    $minutos = floor(($duracion % 3600) / 60);
                                ?>
                                <?php if($duracion > 0): ?>
                                    <?php echo e($horas); ?>h <?php echo e($minutos); ?>m
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-transcribir"
                                        data-id="<?php echo e($entrevista->id_e_ind_fvt); ?>"
                                        title="Iniciar transcripcion">
                                    <i class="fas fa-play"></i>
                                </button>
                                <a href="<?php echo e(route('adjuntos.gestionar', $entrevista->id_e_ind_fvt)); ?>"
                                   class="btn btn-sm btn-secondary" title="Ver adjuntos">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                                No hay entrevistas pendientes de transcripcion
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($entrevistas->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($entrevistas->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Acciones en lote -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Acciones en Lote</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Seleccione entrevistas de la lista para procesarlas en lote.</p>
                <div class="form-group">
                    <label>Entrevistas seleccionadas:</label>
                    <span id="count-seleccionadas" class="badge badge-primary">0</span>
                </div>
                <button class="btn btn-primary btn-block" id="btn-procesar-lote" disabled>
                    <i class="fas fa-play mr-2"></i>Iniciar Transcripcion
                </button>
            </div>
        </div>

        <!-- Configuración -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Configuracion</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Modelo de Whisper</label>
                    <select class="form-control" id="modelo-whisper">
                        <option value="large-v3-turbo">large-v3-turbo (Recomendado)</option>
                        <option value="large-v3">large-v3 (Mas preciso)</option>
                        <option value="large-v2">large-v2</option>
                        <option value="medium">medium (Mas rapido)</option>
                        <option value="small">small (Rapido)</option>
                    </select>
                    <small class="text-muted">Modelos mas grandes son mas precisos pero mas lentos</small>
                </div>
                <div class="form-group">
                    <label>Idioma</label>
                    <select class="form-control" id="idioma">
                        <option value="es">Español</option>
                        <option value="auto">Detectar automaticamente</option>
                    </select>
                </div>
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="diarizar" checked>
                    <label class="custom-control-label" for="diarizar">Diarizacion (identificar hablantes)</label>
                </div>
            </div>
        </div>

        <!-- Info del sistema -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-server mr-2"></i>Estado del Servicio</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="verificarServicio()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <span id="status-whisper-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Motor WhisperX: <strong id="status-whisper">Verificando...</strong>
                    </li>
                    <li class="mb-2">
                        <span id="status-gpu-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        GPU/Dispositivo: <strong id="status-gpu">Verificando...</strong>
                    </li>
                    <li>
                        <span id="status-modelo-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Modelo: <strong id="status-modelo">Verificando...</strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Verificar estado del servicio al cargar
    verificarServicio();

    // Contador de seleccionados
    $('.check-item').on('change', function() {
        var count = $('.check-item:checked').length;
        $('#count-seleccionadas').text(count);
        $('#btn-procesar-lote').prop('disabled', count === 0);
    });

    // Transcribir individual
    $('.btn-transcribir').on('click', function() {
        var id = $(this).data('id');
        var btn = $(this);
        var row = btn.closest('tr');
        var codigo = row.find('code').text();

        if (!confirm('¿Iniciar transcripcion de esta entrevista?\n\nEsto puede tomar varios minutos.')) return;

        // Mostrar panel de resultado
        $('#panel-resultado').slideDown();
        $('#resultado-loading').show();
        $('#resultado-exito, #resultado-error').hide();
        $('#card-resultado').removeClass('card-success card-danger').addClass('card-primary');

        // Scroll al panel
        $('html, body').animate({ scrollTop: 0 }, 300);

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?php echo e(url("procesamientos/transcripcion")); ?>/' + id + '/iniciar',
            method: 'POST',
            timeout: 600000, // 10 minutos
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                modelo: $('#modelo-whisper').val(),
                idioma: $('#idioma').val(),
                diarizar: $('#diarizar').is(':checked') ? 1 : 0
            },
            success: function(response) {
                $('#resultado-loading').hide();

                if (response.success) {
                    $('#card-resultado').removeClass('card-primary card-danger').addClass('card-success');
                    $('#resultado-exito').show();
                    $('#res-codigo').text(codigo);
                    $('#res-caracteres').text(response.text_length ? response.text_length.toLocaleString() : '0');
                    $('#res-hablantes').text(response.speakers || 'N/A');
                    $('#res-texto').val(response.text || 'Sin texto');
                    $('#btn-editar-transcripcion').attr('href', '<?php echo e(url("procesamientos/edicion")); ?>/' + id);

                    // Marcar fila como completada
                    btn.removeClass('btn-primary').addClass('btn-success')
                       .html('<i class="fas fa-check"></i>').prop('disabled', true);
                    row.addClass('table-success');
                } else {
                    mostrarError(response.error || 'Error desconocido');
                    btn.prop('disabled', false).html('<i class="fas fa-play"></i>');
                }
            },
            error: function(xhr) {
                $('#resultado-loading').hide();
                var errorMsg = xhr.responseJSON?.error || 'Error de conexion con el servidor';
                mostrarError(errorMsg);
                btn.prop('disabled', false).html('<i class="fas fa-play"></i>');
            }
        });
    });

    function mostrarError(mensaje) {
        $('#card-resultado').removeClass('card-primary card-success').addClass('card-danger');
        $('#resultado-error').show();
        $('#res-error-mensaje').text(mensaje);
    }

    // Procesar en lote
    $('#btn-procesar-lote').on('click', function() {
        var ids = [];
        $('.check-item:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) return;

        if (!confirm('¿Iniciar transcripcion de ' + ids.length + ' entrevista(s)?')) return;

        alert('Funcionalidad de procesamiento en lote pendiente de implementacion');
    });
});

function verificarServicio() {
    $.get('<?php echo e(route("procesamientos.servicios-status")); ?>', function(data) {
        if (data.transcription && !data.transcription.error) {
            // Servicio disponible
            $('#status-whisper-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
            $('#status-whisper').text('Disponible');

            // GPU/Dispositivo
            var device = data.transcription.device || 'cpu';
            if (device === 'cuda' || device.includes('GPU')) {
                $('#status-gpu-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
                $('#status-gpu').text('GPU CUDA Activo');
            } else {
                $('#status-gpu-icon').html('<i class="fas fa-circle text-warning mr-2"></i>');
                $('#status-gpu').text('CPU (Sin GPU)');
            }

            // Modelo
            var modelo = data.transcription.model || 'large-v2';
            $('#status-modelo-icon').html('<i class="fas fa-circle text-info mr-2"></i>');
            $('#status-modelo').text(modelo);

            // Habilitar botones
            $('.btn-transcribir, #btn-procesar-lote').prop('disabled', false);
        } else {
            // Servicio no disponible
            $('#status-whisper-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
            $('#status-whisper').text('No disponible');
            $('#status-gpu-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
            $('#status-gpu').text('-');
            $('#status-modelo-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
            $('#status-modelo').text('-');

            // Deshabilitar botones
            $('.btn-transcribir, #btn-procesar-lote').prop('disabled', true);
        }
    }).fail(function() {
        $('#status-whisper-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
        $('#status-whisper').text('Error de conexion');
        $('#status-gpu-icon, #status-modelo-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
        $('#status-gpu, #status-modelo').text('-');
        $('.btn-transcribir, #btn-procesar-lote').prop('disabled', true);
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/procesamientos/transcripcion.blade.php ENDPATH**/ ?>
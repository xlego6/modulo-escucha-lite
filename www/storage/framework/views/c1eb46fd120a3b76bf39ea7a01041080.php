

<?php $__env->startSection('title', 'Deteccion de Entidades'); ?>
<?php $__env->startSection('content_header', 'Deteccion de Entidades'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="callout callout-warning">
            <h5><i class="fas fa-brain mr-2"></i>spaCy NER - Reconocimiento de Entidades</h5>
            <p class="mb-0">
                Sistema de deteccion de entidades nombradas (NER) basado en spaCy con modelo en español.
                Identifica personas, lugares, organizaciones, fechas, eventos y otros elementos relevantes.
            </p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Tipos de entidades -->
    <div class="col-md-12 mb-3">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tags mr-2"></i>Tipos de Entidades Detectables</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__currentLoopData = $tiposEntidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-sm-4 col-6 mb-2">
                        <span class="badge badge-<?php echo e($tipo == 'PER' ? 'primary' : ($tipo == 'LOC' ? 'success' : ($tipo == 'ORG' ? 'info' : ($tipo == 'DATE' ? 'secondary' : ($tipo == 'EVENT' ? 'warning' : ($tipo == 'GUN' ? 'danger' : 'dark')))))); ?> p-2">
                            <?php echo e($tipo); ?>

                        </span>
                        <span class="ml-2"><?php echo e($nombre); ?></span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Entrevistas Pendientes de Analisis</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Archivos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                <span class="badge badge-info">
                                    <?php echo e($entrevista->rel_adjuntos->count()); ?> audios
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-detectar"
                                        data-id="<?php echo e($entrevista->id_e_ind_fvt); ?>"
                                        title="Detectar entidades">
                                    <i class="fas fa-search"></i> Detectar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                                No hay entrevistas pendientes de analisis
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($pendientes->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($pendientes->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Acciones en lote -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-tasks mr-2"></i>Procesamiento en Lote</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Seleccione entrevistas para detectar entidades en lote.</p>
                <div class="form-group">
                    <label>Seleccionadas:</label>
                    <span id="count-seleccionadas" class="badge badge-warning">0</span>
                </div>
                <button class="btn btn-warning btn-block" id="btn-procesar-lote" disabled>
                    <i class="fas fa-search mr-2"></i>Detectar Entidades
                </button>
            </div>
        </div>

        <!-- Estado del Servicio NER -->
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
                        <span id="status-ner-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Servicio NER: <strong id="status-ner">Verificando...</strong>
                    </li>
                    <li class="mb-2">
                        <span id="status-modelo-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Modelo: <strong id="status-modelo">Verificando...</strong>
                    </li>
                    <li>
                        <span id="status-tipos-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Entidades: <strong id="status-tipos">Verificando...</strong>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Entrevistas procesadas recientemente -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle mr-2"></i>Procesadas Recientemente</h3>
            </div>
            <div class="card-body p-0">
                <?php if($procesadas->count() > 0): ?>
                <ul class="list-group list-group-flush">
                    <?php $__currentLoopData = $procesadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted"><?php echo e($ent->entrevista_codigo); ?></small><br>
                            <?php echo e(\Illuminate\Support\Str::limit($ent->titulo, 25)); ?>

                        </div>
                        <a href="<?php echo e(route('procesamientos.ver-entidades', $ent->id_e_ind_fvt)); ?>"
                           class="btn btn-sm btn-outline-success">
                            <i class="fas fa-eye"></i>
                        </a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php else: ?>
                <div class="text-center text-muted py-3">
                    <p class="mb-0">No hay entrevistas procesadas</p>
                </div>
                <?php endif; ?>
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

    // Detectar individual
    $('.btn-detectar').on('click', function() {
        var id = $(this).data('id');
        var btn = $(this);

        if (!confirm('¿Iniciar deteccion de entidades?')) return;

        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: '<?php echo e(url("procesamientos/entidades")); ?>/' + id + '/detectar',
            method: 'POST',
            data: { _token: '<?php echo e(csrf_token()); ?>' },
            success: function(response) {
                alert('Deteccion iniciada correctamente');
                location.reload();
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.error || 'Error desconocido'));
                btn.prop('disabled', false).html('<i class="fas fa-search"></i> Detectar');
            }
        });
    });

    // Procesar en lote
    $('#btn-procesar-lote').on('click', function() {
        var ids = [];
        $('.check-item:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) return;

        if (!confirm('¿Detectar entidades en ' + ids.length + ' entrevista(s)?')) return;

        alert('Funcionalidad de procesamiento en lote pendiente de implementacion');
    });
});

function verificarServicio() {
    $.get('<?php echo e(route("procesamientos.servicios-status")); ?>', function(data) {
        if (data.ner && !data.ner.error) {
            // Servicio disponible
            $('#status-ner-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
            $('#status-ner').text('Disponible');

            // Modelo
            var modelo = data.ner.model || 'Personalizado';
            $('#status-modelo-icon').html('<i class="fas fa-circle text-info mr-2"></i>');
            $('#status-modelo').text(modelo);

            // Tipos de entidades
            if (data.ner.entity_types) {
                $('#status-tipos-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
                $('#status-tipos').text(data.ner.entity_types.length + ' tipos');
            } else {
                $('#status-tipos-icon').html('<i class="fas fa-circle text-info mr-2"></i>');
                $('#status-tipos').text('7 tipos');
            }

            // Habilitar botones
            $('.btn-detectar').prop('disabled', false);
        } else {
            // Servicio no disponible
            $('#status-ner-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
            $('#status-ner').text('No disponible');
            $('#status-modelo-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
            $('#status-modelo').text('-');
            $('#status-tipos-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
            $('#status-tipos').text('-');

            // Deshabilitar botones
            $('.btn-detectar').prop('disabled', true);
        }
    }).fail(function() {
        $('#status-ner-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
        $('#status-ner').text('Error de conexion');
        $('#status-modelo-icon, #status-tipos-icon').html('<i class="fas fa-circle text-secondary mr-2"></i>');
        $('#status-modelo, #status-tipos').text('-');
        $('.btn-detectar').prop('disabled', true);
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/procesamientos/entidades.blade.php ENDPATH**/ ?>
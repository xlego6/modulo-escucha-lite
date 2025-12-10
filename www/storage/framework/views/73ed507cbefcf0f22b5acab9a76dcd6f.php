<?php if($resultados->count() > 0): ?>
<table class="table table-hover">
    <thead>
        <tr>
            <th style="width: 50px"></th>
            <th>Documento</th>
            <th>Entrevista</th>
            <th>Tipo</th>
            <th style="width: 120px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adjunto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr class="<?php echo e($adjunto->coincidencia_texto ? 'resultado-adjunto' : ''); ?>">
            <td class="text-center">
                <?php if($adjunto->es_audio): ?>
                    <i class="fas fa-volume-up fa-2x text-info"></i>
                <?php elseif($adjunto->es_video): ?>
                    <i class="fas fa-video fa-2x text-danger"></i>
                <?php elseif($adjunto->es_documento): ?>
                    <i class="fas fa-file-pdf fa-2x text-danger"></i>
                <?php else: ?>
                    <i class="fas fa-file fa-2x text-secondary"></i>
                <?php endif; ?>
            </td>
            <td>
                <strong><?php echo e($adjunto->nombre_original); ?></strong>
                <br>
                <small class="text-muted">
                    <?php echo e($adjunto->fmt_tamano); ?>

                    <?php if($adjunto->duracion): ?>
                        | <?php echo e($adjunto->fmt_duracion); ?>

                    <?php endif; ?>
                </small>
                <?php if($adjunto->coincidencia_texto && $adjunto->extracto): ?>
                <div class="extracto-texto mt-2">
                    <i class="fas fa-quote-left text-muted"></i>
                    <?php echo $adjunto->extracto; ?>

                </div>
                <?php endif; ?>
            </td>
            <td>
                <?php if($adjunto->rel_entrevista): ?>
                <a href="<?php echo e(route('entrevistas.show', $adjunto->rel_entrevista->id_e_ind_fvt)); ?>">
                    <span class="badge badge-primary"><?php echo e($adjunto->rel_entrevista->entrevista_codigo); ?></span>
                </a>
                <br>
                <small><?php echo e(\Illuminate\Support\Str::limit($adjunto->rel_entrevista->titulo, 40)); ?></small>
                <?php else: ?>
                <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($adjunto->rel_tipo): ?>
                    <span class="badge badge-secondary"><?php echo e($adjunto->rel_tipo->descripcion); ?></span>
                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td>
                <div class="btn-group">
                    <a href="<?php echo e(route('adjuntos.ver', $adjunto->id_adjunto)); ?>" class="btn btn-info btn-sm" title="Ver" target="_blank">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="<?php echo e(route('adjuntos.descargar', $adjunto->id_adjunto)); ?>" class="btn btn-secondary btn-sm" title="Descargar">
                        <i class="fas fa-download"></i>
                    </a>
                    <?php if($adjunto->rel_entrevista): ?>
                    <a href="<?php echo e(route('adjuntos.gestionar', $adjunto->rel_entrevista->id_e_ind_fvt)); ?>" class="btn btn-warning btn-sm" title="Gestionar adjuntos">
                        <i class="fas fa-folder-open"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php else: ?>
<div class="text-center py-4">
    <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
    <p class="text-muted">No se encontraron documentos</p>
</div>
<?php endif; ?>
<?php /**PATH /var/www/resources/views/buscador/_resultados_documentos.blade.php ENDPATH**/ ?>
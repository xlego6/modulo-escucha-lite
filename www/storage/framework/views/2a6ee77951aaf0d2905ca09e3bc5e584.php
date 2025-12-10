<table class="table table-hover table-striped">
    <thead>
        <tr>
            <th style="width: 120px">Codigo</th>
            <th>Titulo</th>
            <th style="width: 100px">Fecha</th>
            <th style="width: 150px">Lugar</th>
            <th style="width: 150px">Entrevistador</th>
            <th style="width: 80px">Adjuntos</th>
            <th style="width: 80px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td>
                <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>">
                    <strong><?php echo e($entrevista->entrevista_codigo); ?></strong>
                </a>
            </td>
            <td>
                <?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 50)); ?>

                <?php if($entrevista->anotaciones): ?>
                <br><small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($entrevista->anotaciones, 60)); ?></small>
                <?php endif; ?>
            </td>
            <td><?php echo e($entrevista->fmt_fecha); ?></td>
            <td>
                <?php if($entrevista->rel_lugar_entrevista): ?>
                    <?php echo e($entrevista->rel_lugar_entrevista->descripcion); ?>

                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($entrevista->rel_entrevistador && $entrevista->rel_entrevistador->rel_usuario): ?>
                    <?php echo e($entrevista->rel_entrevistador->rel_usuario->name); ?>

                <?php else: ?>
                    <span class="text-muted">-</span>
                <?php endif; ?>
            </td>
            <td class="text-center">
                <?php $num_adjuntos = $entrevista->rel_adjuntos ? $entrevista->rel_adjuntos->count() : 0; ?>
                <?php if($num_adjuntos > 0): ?>
                    <span class="badge badge-info"><?php echo e($num_adjuntos); ?></span>
                <?php else: ?>
                    <span class="text-muted">0</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-info btn-sm" title="Ver">
                    <i class="fas fa-eye"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="7" class="text-center text-muted py-4">
                No se encontraron entrevistas
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php /**PATH /var/www/resources/views/buscador/_resultados_entrevistas.blade.php ENDPATH**/ ?>
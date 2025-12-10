

<?php $__env->startSection('title', 'Edicion de Transcripciones'); ?>
<?php $__env->startSection('content_header', 'Edicion de Transcripciones'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pendientes</span>
                <span class="info-box-number"><?php echo e($stats['pendientes']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Revisadas</span>
                <span class="info-box-number"><?php echo e($stats['revisadas']); ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Transcripciones Pendientes de Revision</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Titulo</th>
                    <th>Fecha</th>
                    <th>Adjuntos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><code><?php echo e($entrevista->entrevista_codigo); ?></code></td>
                    <td>
                        <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>">
                            <?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 45)); ?>

                        </a>
                    </td>
                    <td>
                        <?php if($entrevista->created_at): ?>
                            <?php echo e($entrevista->created_at->format('d/m/Y')); ?>

                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <?php echo e($entrevista->rel_adjuntos->count()); ?> adjuntos
                        </span>
                    </td>
                    <td>
                        <a href="<?php echo e(route('procesamientos.editar-transcripcion', $entrevista->id_e_ind_fvt)); ?>"
                           class="btn btn-sm btn-primary" title="Editar transcripcion">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="<?php echo e(route('procesamientos.aprobar-transcripcion', $entrevista->id_e_ind_fvt)); ?>"
                              method="POST" class="d-inline" onsubmit="return confirm('¿Aprobar esta transcripcion?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-sm btn-success" title="Aprobar sin cambios">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                        No hay transcripciones pendientes de revision
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/procesamientos/edicion.blade.php ENDPATH**/ ?>
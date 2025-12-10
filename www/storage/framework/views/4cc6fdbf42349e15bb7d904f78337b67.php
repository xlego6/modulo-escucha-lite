

<?php $__env->startSection('title', 'Dashboard - Testimonios'); ?>
<?php $__env->startSection('content_header', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo e($stats['total_entrevistas'] ?? 0); ?></h3>
                <p>Total Entrevistas</p>
            </div>
            <div class="icon">
                <i class="fas fa-microphone"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo e($stats['total_personas'] ?? 0); ?></h3>
                <p>Personas Registradas</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo e($stats['total_adjuntos'] ?? 0); ?></h3>
                <p>Archivos Adjuntos</p>
            </div>
            <div class="icon">
                <i class="fas fa-paperclip"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?php echo e($stats['entrevistas_mes'] ?? 0); ?></h3>
                <p>Entrevistas este Mes</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ultimas Entrevistas</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $ultimas_entrevistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($entrevista->fmt_codigo); ?></td>
                            <td><?php echo e(\Illuminate\Support\Str::limit($entrevista->fmt_titulo, 50)); ?></td>
                            <td><?php echo e($entrevista->fmt_fecha); ?></td>
                            <td>
                                <?php if($entrevista->id_activo == 1): ?>
                                    <span class="badge badge-success">Activa</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inactiva</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay entrevistas registradas</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home/index.blade.php ENDPATH**/ ?>
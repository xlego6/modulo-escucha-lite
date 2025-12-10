

<?php $__env->startSection('title', 'Permisos de Acceso'); ?>
<?php $__env->startSection('content_header', 'Permisos de Acceso a Entrevistas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <form action="<?php echo e(route('permisos.index')); ?>" method="GET" class="form-inline">
                    <select name="id_entrevistador" class="form-control mr-2">
                        <?php $__currentLoopData = $entrevistadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php echo e(request('id_entrevistador') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <select name="vigente" class="form-control mr-2">
                        <option value="">-- Vigencia --</option>
                        <option value="1" <?php echo e(request('vigente') == '1' ? 'selected' : ''); ?>>Vigentes</option>
                        <option value="0" <?php echo e(request('vigente') == '0' ? 'selected' : ''); ?>>Vencidos</option>
                    </select>
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="<?php echo e(route('permisos.index')); ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i>
                    </a>
                </form>
            </div>
            <div class="col-md-4 text-right">
                <a href="<?php echo e(route('permisos.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Otorgar Permiso
                </a>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Entrevista</th>
                    <th>Tipo</th>
                    <th>Otorgado</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($permiso->id_permiso); ?></td>
                    <td>
                        <?php if($permiso->rel_entrevistador && $permiso->rel_entrevistador->rel_usuario): ?>
                            <?php echo e($permiso->rel_entrevistador->rel_usuario->name); ?>

                        <?php else: ?>
                            <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($permiso->rel_entrevista): ?>
                            <a href="<?php echo e(route('entrevistas.show', $permiso->id_e_ind_fvt)); ?>">
                                <?php echo e($permiso->rel_entrevista->entrevista_codigo); ?>

                            </a>
                            <br><small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($permiso->rel_entrevista->titulo, 30)); ?></small>
                        <?php else: ?>
                            <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($permiso->id_tipo == 3 ? 'danger' : ($permiso->id_tipo == 2 ? 'warning' : 'info')); ?>">
                            <?php echo e($permiso->fmt_tipo); ?>

                        </span>
                    </td>
                    <td><?php echo e($permiso->fecha_otorgado ? $permiso->fecha_otorgado->format('d/m/Y') : 'N/A'); ?></td>
                    <td><?php echo e($permiso->fecha_vencimiento ? $permiso->fecha_vencimiento->format('d/m/Y') : 'Sin limite'); ?></td>
                    <td>
                        <?php if($permiso->esta_vigente): ?>
                            <span class="badge badge-success">Vigente</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Vencido</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('permisos.show', $permiso->id_permiso)); ?>" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="<?php echo e(route('permisos.destroy', $permiso->id_permiso)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Esta seguro de revocar este permiso?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" title="Revocar">
                                <i class="fas fa-ban"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron permisos</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($permisos->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($permisos->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/permisos/index.blade.php ENDPATH**/ ?>
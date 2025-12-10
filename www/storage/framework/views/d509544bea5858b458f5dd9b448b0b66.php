

<?php $__env->startSection('title', 'Usuarios'); ?>
<?php $__env->startSection('content_header', 'Gestion de Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form action="<?php echo e(route('usuarios.index')); ?>" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="buscar" class="form-control" placeholder="Buscar usuario..." value="<?php echo e(request('buscar')); ?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                <a href="<?php echo e(route('usuarios.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Nuevo Usuario
                </a>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Nivel</th>
                    <th>Solo Lectura</th>
                    <th width="150">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($usuario->id); ?></td>
                    <td><?php echo e($usuario->name); ?></td>
                    <td><?php echo e($usuario->email); ?></td>
                    <td>
                        <span class="badge badge-<?php echo e($usuario->id_nivel == 1 ? 'danger' : ($usuario->id_nivel <= 4 ? 'warning' : 'info')); ?>">
                            <?php echo e($usuario->fmt_privilegios); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($usuario->solo_lectura): ?>
                            <span class="badge badge-secondary">Si</span>
                        <?php else: ?>
                            <span class="badge badge-success">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('usuarios.show', $usuario->id)); ?>" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('usuarios.edit', $usuario->id)); ?>" class="btn btn-sm btn-warning" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if($usuario->id != Auth::id()): ?>
                        <form action="<?php echo e(route('usuarios.destroy', $usuario->id)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Esta seguro de eliminar este usuario?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">No se encontraron usuarios</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($usuarios->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($usuarios->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/usuarios/index.blade.php ENDPATH**/ ?>
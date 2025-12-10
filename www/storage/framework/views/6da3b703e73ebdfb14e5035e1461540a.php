

<?php $__env->startSection('title', 'Entrevistas'); ?>
<?php $__env->startSection('content_header', 'Listado de Entrevistas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filtros de busqueda</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('entrevistas.wizard.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Entrevista
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('entrevistas.index')); ?>" class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Codigo</label>
                    <input type="text" name="codigo" class="form-control form-control-sm" value="<?php echo e(request('codigo')); ?>" placeholder="VI-0001-001">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Titulo</label>
                    <input type="text" name="titulo" class="form-control form-control-sm" value="<?php echo e(request('titulo')); ?>" placeholder="Buscar en titulo...">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Fecha desde</label>
                    <input type="date" name="fecha_desde" class="form-control form-control-sm" value="<?php echo e(request('fecha_desde')); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Fecha hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control form-control-sm" value="<?php echo e(request('fecha_hasta')); ?>">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Entrevistador</label>
                    <select name="id_entrevistador" class="form-control form-control-sm">
                        <?php $__currentLoopData = $entrevistadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(request('id_entrevistador') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-info btn-sm btn-block">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Entrevistas (<?php echo e($entrevistas->total()); ?> registros)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th style="width: 120px">Codigo</th>
                    <th>Titulo</th>
                    <th style="width: 100px">Fecha</th>
                    <th style="width: 150px">Entrevistador</th>
                    <th style="width: 80px">Duracion</th>
                    <th style="width: 120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $entrevistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>">
                            <strong><?php echo e($entrevista->entrevista_codigo); ?></strong>
                        </a>
                    </td>
                    <td><?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 60)); ?></td>
                    <td><?php echo e($entrevista->fmt_fecha); ?></td>
                    <td>
                        <?php if($entrevista->rel_entrevistador && $entrevista->rel_entrevistador->rel_usuario): ?>
                            <?php echo e($entrevista->rel_entrevistador->rel_usuario->name); ?>

                        <?php else: ?>
                            <span class="text-muted">Sin asignar</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($entrevista->tiempo_entrevista): ?>
                            <?php echo e($entrevista->tiempo_entrevista); ?> min
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('entrevistas.wizard.edit', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('entrevistas.destroy', $entrevista->id_e_ind_fvt)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Esta seguro de eliminar esta entrevista?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-3x mb-3"></i>
                        <p>No se encontraron entrevistas</p>
                        <a href="<?php echo e(route('entrevistas.wizard.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear primera entrevista
                        </a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($entrevistas->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($entrevistas->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/entrevistas/index.blade.php ENDPATH**/ ?>
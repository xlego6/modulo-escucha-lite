

<?php $__env->startSection('title', 'Personas'); ?>
<?php $__env->startSection('content_header', 'Listado de Personas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filtros de busqueda</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('personas.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Persona
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="<?php echo e(route('personas.index')); ?>" class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nombre / Apellido</label>
                    <input type="text" name="nombre" class="form-control form-control-sm" value="<?php echo e(request('nombre')); ?>" placeholder="Buscar por nombre...">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Documento</label>
                    <input type="text" name="documento" class="form-control form-control-sm" value="<?php echo e(request('documento')); ?>" placeholder="Numero de documento">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Sexo</label>
                    <select name="id_sexo" class="form-control form-control-sm">
                        <?php $__currentLoopData = $sexos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(request('id_sexo') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Grupo Etnico</label>
                    <select name="id_etnia" class="form-control form-control-sm">
                        <?php $__currentLoopData = $etnias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(request('id_etnia') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
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
        <h3 class="card-title">Personas (<?php echo e($personas->total()); ?> registros)</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th style="width: 120px">Documento</th>
                    <th style="width: 100px">Sexo</th>
                    <th style="width: 150px">Grupo Etnico</th>
                    <th style="width: 120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $personas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>">
                            <strong><?php echo e($persona->fmt_nombre_completo); ?></strong>
                        </a>
                        <?php if($persona->alias): ?>
                            <br><small class="text-muted">Alias: <?php echo e($persona->alias); ?></small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($persona->num_documento): ?>
                            <small class="text-muted"><?php echo e($persona->rel_tipo_documento->descripcion ?? 'DOC'); ?>:</small><br>
                            <?php echo e($persona->num_documento); ?>

                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($persona->fmt_sexo); ?></td>
                    <td>
                        <?php if($persona->rel_etnia): ?>
                            <?php echo e($persona->rel_etnia->descripcion); ?>

                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>" class="btn btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('personas.edit', $persona->id_persona)); ?>" class="btn btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('personas.destroy', $persona->id_persona)); ?>" method="POST" style="display:inline" onsubmit="return confirm('Esta seguro de eliminar esta persona?')">
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
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <p>No se encontraron personas</p>
                        <a href="<?php echo e(route('personas.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Registrar primera persona
                        </a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($personas->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($personas->appends(request()->query())->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/personas/index.blade.php ENDPATH**/ ?>
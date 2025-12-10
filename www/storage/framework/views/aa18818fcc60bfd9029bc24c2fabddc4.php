

<?php $__env->startSection('title', 'Catalogos'); ?>
<?php $__env->startSection('content_header', 'Gestion de Catalogos'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i>Listado de Catalogos</h3>
        <div class="card-tools">
            <a href="<?php echo e(route('catalogos.create')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus mr-1"></i>Nuevo Catalogo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th style="width: 60px">ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th style="width: 100px" class="text-center">Items</th>
                    <th style="width: 100px" class="text-center">Editable</th>
                    <th style="width: 150px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $catalogos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catalogo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($catalogo->id_cat); ?></td>
                    <td>
                        <a href="<?php echo e(route('catalogos.show', $catalogo->id_cat)); ?>">
                            <strong><?php echo e($catalogo->nombre); ?></strong>
                        </a>
                    </td>
                    <td class="text-muted"><?php echo e($catalogo->descripcion ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="badge badge-info"><?php echo e($catalogo->rel_items_count); ?></span>
                    </td>
                    <td class="text-center">
                        <?php if($catalogo->editable): ?>
                            <span class="badge badge-success">Si</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">No</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('catalogos.show', $catalogo->id_cat)); ?>" class="btn btn-info btn-sm" title="Ver items">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if($catalogo->editable): ?>
                        <a href="<?php echo e(route('catalogos.edit', $catalogo->id_cat)); ?>" class="btn btn-warning btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        No hay catalogos registrados
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($catalogos->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($catalogos->links()); ?>

    </div>
    <?php endif; ?>
</div>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informacion</h3>
    </div>
    <div class="card-body">
        <p>Los catalogos contienen las listas cerradas utilizadas en los formularios del sistema, como:</p>
        <ul class="mb-0">
            <li><strong>Sexo, Etnia, Discapacidad:</strong> Datos demograficos de testimoniantes</li>
            <li><strong>Dependencias:</strong> Areas del CNMH que realizan entrevistas</li>
            <li><strong>Tipos de Testimonio:</strong> Clasificacion de entrevistas</li>
            <li><strong>Hechos Victimizantes:</strong> Categorias de hechos narrados</li>
            <li><strong>Responsables:</strong> Actores mencionados en testimonios</li>
        </ul>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/catalogos/index.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Permisos de Acceso'); ?>
<?php $__env->startSection('content_header', 'Permisos de Acceso a Entrevistas'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-9">
                <form action="<?php echo e(route('permisos.index')); ?>" method="GET" class="form-inline">
                    <select name="id_entrevistador" class="form-control form-control-sm mr-2 mb-2">
                        <?php $__currentLoopData = $entrevistadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php echo e(request('id_entrevistador') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="text" name="codigo" class="form-control form-control-sm mr-2 mb-2" placeholder="Codigo entrevista" value="<?php echo e(request('codigo')); ?>">
                    <select name="estado" class="form-control form-control-sm mr-2 mb-2">
                        <option value="">-- Estado --</option>
                        <option value="1" <?php echo e(request('estado') == '1' ? 'selected' : ''); ?>>Vigentes</option>
                        <option value="2" <?php echo e(request('estado') == '2' ? 'selected' : ''); ?>>Revocados</option>
                    </select>
                    <select name="tipo" class="form-control form-control-sm mr-2 mb-2">
                        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>" <?php echo e(request('tipo') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-default mr-2 mb-2">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="<?php echo e(route('permisos.index')); ?>" class="btn btn-sm btn-secondary mb-2">
                        <i class="fas fa-times"></i>
                    </a>
                </form>
            </div>
            <div class="col-md-3 text-right">
                <a href="<?php echo e(route('permisos.create')); ?>" class="btn btn-sm btn-primary mr-1">
                    <i class="fas fa-plus mr-1"></i> Otorgar
                </a>
                <a href="<?php echo e(route('permisos.desclasificar')); ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-unlock-alt mr-1"></i> Desclasificar
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
                    <th>Rango/Vencimiento</th>
                    <th>Otorgado</th>
                    <th>Soporte</th>
                    <th>Estado</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="<?php echo e($permiso->id_estado == 2 ? 'table-secondary' : ''); ?>">
                    <td><?php echo e($permiso->id_permiso); ?></td>
                    <td>
                        <?php if($permiso->rel_entrevistador && $permiso->rel_entrevistador->rel_usuario): ?>
                            <a href="<?php echo e(route('permisos.por_usuario', $permiso->id_entrevistador)); ?>">
                                <?php echo e($permiso->rel_entrevistador->rel_usuario->name); ?>

                            </a>
                        <?php else: ?>
                            <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($permiso->rel_entrevista): ?>
                            <a href="<?php echo e(route('entrevistas.show', $permiso->id_e_ind_fvt)); ?>">
                                <?php echo e($permiso->codigo_entrevista ?? $permiso->rel_entrevista->entrevista_codigo); ?>

                            </a>
                            <br><small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($permiso->rel_entrevista->titulo, 30)); ?></small>
                        <?php else: ?>
                            <span class="text-muted"><?php echo e($permiso->codigo_entrevista ?? 'N/A'); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($permiso->id_tipo == 3 ? 'danger' : ($permiso->id_tipo == 2 ? 'warning' : 'info')); ?>">
                            <?php echo e($permiso->fmt_tipo); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($permiso->fecha_desde || $permiso->fecha_hasta): ?>
                            <small><?php echo e($permiso->fmt_rango_fechas); ?></small>
                        <?php elseif($permiso->fecha_vencimiento): ?>
                            <small>Hasta <?php echo e($permiso->fecha_vencimiento->format('d/m/Y')); ?></small>
                        <?php else: ?>
                            <small class="text-muted">Sin limite</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small><?php echo e($permiso->fecha_otorgado ? $permiso->fecha_otorgado->format('d/m/Y') : 'N/A'); ?></small>
                        <?php if($permiso->rel_otorgado_por && $permiso->rel_otorgado_por->rel_usuario): ?>
                            <br><small class="text-muted">por <?php echo e($permiso->rel_otorgado_por->rel_usuario->name); ?></small>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <?php if($permiso->rel_adjunto): ?>
                            <a href="<?php echo e(route('permisos.descargar_soporte', $permiso->id_permiso)); ?>" class="text-primary" title="Descargar soporte">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($permiso->id_estado == 2): ?>
                            <span class="badge badge-danger">Revocado</span>
                        <?php elseif($permiso->esta_vigente): ?>
                            <span class="badge badge-success">Vigente</span>
                        <?php else: ?>
                            <span class="badge badge-secondary">Vencido</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('permisos.show', $permiso->id_permiso)); ?>" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <?php if($permiso->id_estado != 2): ?>
                        <form action="<?php echo e(route('permisos.destroy', $permiso->id_permiso)); ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Esta seguro de revocar este permiso?');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" title="Revocar">
                                <i class="fas fa-ban"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">No se encontraron permisos</p>
                    </td>
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
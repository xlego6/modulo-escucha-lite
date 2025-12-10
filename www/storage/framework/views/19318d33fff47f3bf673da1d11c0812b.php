

<?php $__env->startSection('title', 'Traza de Actividad'); ?>
<?php $__env->startSection('content_header', 'Traza de Actividad del Sistema'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-filter mr-2"></i>Filtros de Busqueda</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('traza.index')); ?>" method="GET">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="id_usuario">Usuario</label>
                        <select class="form-control" id="id_usuario" name="id_usuario">
                            <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>" <?php echo e(request('id_usuario') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="accion">Accion</label>
                        <select class="form-control" id="accion" name="accion">
                            <?php $__currentLoopData = $acciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(request('accion') == $key ? 'selected' : ''); ?>><?php echo e($valor); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="objeto">Objeto</label>
                        <select class="form-control" id="objeto" name="objeto">
                            <?php $__currentLoopData = $objetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $valor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(request('objeto') == $key ? 'selected' : ''); ?>><?php echo e($valor); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_desde">Fecha Desde</label>
                        <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?php echo e(request('fecha_desde')); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="fecha_hasta">Fecha Hasta</label>
                        <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?php echo e(request('fecha_hasta')); ?>">
                    </div>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <div class="form-group mb-0 w-100">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label for="busqueda">Buscar en Codigo/Referencia</label>
                        <input type="text" class="form-control" id="busqueda" name="busqueda" value="<?php echo e(request('busqueda')); ?>" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-md-8 d-flex align-items-end justify-content-end">
                    <a href="<?php echo e(route('traza.index')); ?>" class="btn btn-default mr-2">
                        <i class="fas fa-eraser mr-1"></i>Limpiar
                    </a>
                    <a href="<?php echo e(route('traza.estadisticas')); ?>" class="btn btn-info">
                        <i class="fas fa-chart-bar mr-1"></i>Estadisticas
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list mr-2"></i>Registro de Actividad</h3>
        <div class="card-tools">
            <span class="badge badge-info"><?php echo e($trazas->total()); ?> registros</span>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th style="width: 150px">Fecha/Hora</th>
                    <th style="width: 180px">Usuario</th>
                    <th style="width: 120px">Accion</th>
                    <th style="width: 100px">Objeto</th>
                    <th>Codigo</th>
                    <th>Referencia</th>
                    <th style="width: 80px">IP</th>
                    <th style="width: 60px">Ver</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $trazas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $traza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td>
                        <small><?php echo e($traza->fmt_fecha_hora); ?></small>
                    </td>
                    <td>
                        <?php if($traza->rel_usuario): ?>
                            <span title="<?php echo e($traza->rel_usuario->email); ?>"><?php echo e($traza->rel_usuario->name); ?></span>
                        <?php else: ?>
                            <span class="text-muted">Usuario eliminado</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($traza->badge_class); ?>"><?php echo e($traza->fmt_accion); ?></span>
                    </td>
                    <td>
                        <small><?php echo e($traza->fmt_objeto); ?></small>
                    </td>
                    <td>
                        <?php if($traza->codigo): ?>
                            <code><?php echo e(\Illuminate\Support\Str::limit($traza->codigo, 25)); ?></code>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small class="text-muted"><?php echo e(\Illuminate\Support\Str::limit($traza->referencia, 40)); ?></small>
                    </td>
                    <td>
                        <small class="text-muted"><?php echo e($traza->ip); ?></small>
                    </td>
                    <td>
                        <a href="<?php echo e(route('traza.show', $traza->id_traza_actividad)); ?>" class="btn btn-xs btn-info" title="Ver detalle">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        No se encontraron registros de actividad
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($trazas->hasPages()): ?>
    <div class="card-footer">
        <?php echo e($trazas->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/traza/index.blade.php ENDPATH**/ ?>
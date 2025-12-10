

<?php $__env->startSection('title', 'Detalle de Actividad'); ?>
<?php $__env->startSection('content_header', 'Detalle del Registro de Actividad'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informacion del Registro</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl>
                            <dt>ID</dt>
                            <dd><?php echo e($traza->id_traza_actividad); ?></dd>

                            <dt>Fecha y Hora</dt>
                            <dd><?php echo e($traza->fmt_fecha_hora); ?></dd>

                            <dt>Usuario</dt>
                            <dd>
                                <?php if($traza->rel_usuario): ?>
                                    <?php echo e($traza->rel_usuario->name); ?>

                                    <br><small class="text-muted"><?php echo e($traza->rel_usuario->email); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">Usuario eliminado (ID: <?php echo e($traza->id_usuario); ?>)</span>
                                <?php endif; ?>
                            </dd>

                            <dt>Direccion IP</dt>
                            <dd><?php echo e($traza->ip ?? 'No registrada'); ?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                            <dt>Accion</dt>
                            <dd>
                                <span class="badge badge-<?php echo e($traza->badge_class); ?>"><?php echo e($traza->fmt_accion); ?></span>
                            </dd>

                            <dt>Objeto</dt>
                            <dd><?php echo e($traza->fmt_objeto ?: '-'); ?></dd>

                            <dt>ID Registro</dt>
                            <dd><?php echo e($traza->id_registro ?? '-'); ?></dd>
                        </dl>
                    </div>
                </div>

                <hr>

                <dl>
                    <dt>Codigo</dt>
                    <dd>
                        <?php if($traza->codigo): ?>
                            <code class="d-block p-2 bg-light"><?php echo e($traza->codigo); ?></code>
                        <?php else: ?>
                            <span class="text-muted">Sin codigo</span>
                        <?php endif; ?>
                    </dd>

                    <dt>Referencia</dt>
                    <dd>
                        <?php if($traza->referencia): ?>
                            <p class="mb-0"><?php echo e($traza->referencia); ?></p>
                        <?php else: ?>
                            <span class="text-muted">Sin referencia</span>
                        <?php endif; ?>
                    </dd>
                </dl>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('traza.index')); ?>" class="btn btn-default">
                    <i class="fas fa-arrow-left mr-1"></i>Volver al listado
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-clock mr-2"></i>Contexto Temporal</h3>
            </div>
            <div class="card-body">
                <?php
                    $fecha = \Carbon\Carbon::parse($traza->fecha_hora);
                ?>
                <p><strong>Hace:</strong> <?php echo e($fecha->diffForHumans()); ?></p>
                <p><strong>Dia:</strong> <?php echo e($fecha->isoFormat('dddd')); ?></p>
                <p><strong>Fecha completa:</strong> <?php echo e($fecha->isoFormat('D [de] MMMM [de] YYYY')); ?></p>
                <p class="mb-0"><strong>Hora:</strong> <?php echo e($fecha->format('H:i:s')); ?></p>
            </div>
        </div>

        <?php if($traza->id_personificador): ?>
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-secret mr-2"></i>Personificacion</h3>
            </div>
            <div class="card-body">
                <p class="text-muted mb-0">
                    Esta accion fue realizada por un administrador personificando al usuario.
                </p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/traza/show.blade.php ENDPATH**/ ?>
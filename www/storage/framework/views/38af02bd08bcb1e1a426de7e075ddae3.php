

<?php $__env->startSection('title', 'Ver Persona'); ?>
<?php $__env->startSection('content_header', 'Detalle de Testimoniante'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .info-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 0.85rem;
    }
    .info-value {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }
    .section-title {
        border-bottom: 2px solid #007bff;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    .badge-list .badge {
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <!-- Informacion Principal -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user"></i>
                    <?php echo e($persona->fmt_nombre_completo); ?>

                    <?php if($persona->nombre_identitario): ?>
                        <small class="text-muted ml-2">(<?php echo e($persona->nombre_identitario); ?>)</small>
                    <?php endif; ?>
                </h3>
                <div class="card-tools">
                    <a href="<?php echo e(route('personas.edit', $persona->id_persona)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Columna Izquierda: Identificacion -->
                    <div class="col-md-6">
                        <h5 class="section-title"><i class="fas fa-id-card text-primary"></i> Identificacion</h5>

                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Nombre(s)</p>
                                <p class="info-value"><?php echo e($persona->nombre ?? '-'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Apellido(s)</p>
                                <p class="info-value"><?php echo e($persona->apellido ?? '-'); ?></p>
                            </div>
                        </div>

                        <?php if($persona->nombre_identitario): ?>
                        <div class="row">
                            <div class="col-12">
                                <p class="info-label mb-0">Nombre Identitario</p>
                                <p class="info-value"><?php echo e($persona->nombre_identitario); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <h5 class="section-title mt-4"><i class="fas fa-map-marker-alt text-info"></i> Lugar de Origen</h5>

                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Departamento</p>
                                <p class="info-value">
                                    <?php if($departamento_origen): ?>
                                        <?php echo e($departamento_origen->descripcion); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Sin especificar</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Municipio</p>
                                <p class="info-value">
                                    <?php if($persona->rel_lugar_nacimiento): ?>
                                        <?php echo e($persona->rel_lugar_nacimiento->descripcion); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Sin especificar</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <h5 class="section-title mt-4"><i class="fas fa-users text-success"></i> Poblacion</h5>
                        <div class="badge-list">
                            <?php if($persona->rel_poblaciones && $persona->rel_poblaciones->count() > 0): ?>
                                <?php $__currentLoopData = $persona->rel_poblaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poblacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-success"><?php echo e($poblacion->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">Sin especificar</span>
                            <?php endif; ?>
                        </div>

                        <h5 class="section-title mt-4"><i class="fas fa-briefcase text-warning"></i> Ocupacion</h5>
                        <div class="badge-list">
                            <?php if($persona->rel_ocupaciones && $persona->rel_ocupaciones->count() > 0): ?>
                                <?php $__currentLoopData = $persona->rel_ocupaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocupacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-warning"><?php echo e($ocupacion->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">Sin especificar</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Columna Derecha: Caracterizacion -->
                    <div class="col-md-6">
                        <h5 class="section-title"><i class="fas fa-venus-mars text-danger"></i> Caracterizacion</h5>

                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Sexo</p>
                                <p class="info-value"><?php echo e($persona->rel_sexo->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Identidad de Genero</p>
                                <p class="info-value"><?php echo e($persona->rel_identidad->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Orientacion Sexual</p>
                                <p class="info-value"><?php echo e($persona->rel_orientacion->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Grupo Etnico</p>
                                <p class="info-value"><?php echo e($persona->rel_etnia->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Rango Etario</p>
                                <p class="info-value"><?php echo e($persona->rel_rango_etario->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Discapacidad</p>
                                <p class="info-value"><?php echo e($persona->rel_discapacidad->descripcion ?? 'Sin especificar'); ?></p>
                            </div>
                        </div>

                        <?php if($persona->num_documento || $persona->telefono || $persona->correo_electronico): ?>
                        <h5 class="section-title mt-4"><i class="fas fa-address-card text-secondary"></i> Datos Adicionales</h5>

                        <?php if($persona->num_documento): ?>
                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Tipo Documento</p>
                                <p class="info-value"><?php echo e($persona->rel_tipo_documento->descripcion ?? '-'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Numero Documento</p>
                                <p class="info-value"><?php echo e($persona->num_documento ?? '-'); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if($persona->telefono || $persona->correo_electronico): ?>
                        <div class="row">
                            <div class="col-6">
                                <p class="info-label mb-0">Telefono</p>
                                <p class="info-value"><?php echo e($persona->telefono ?? '-'); ?></p>
                            </div>
                            <div class="col-6">
                                <p class="info-label mb-0">Correo Electronico</p>
                                <p class="info-value"><?php echo e($persona->correo_electronico ?? '-'); ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entrevistas Vinculadas -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-microphone"></i>
                    Entrevistas Vinculadas
                    <?php if($entrevistas && count($entrevistas) > 0): ?>
                        <span class="badge badge-info ml-2"><?php echo e(count($entrevistas)); ?></span>
                    <?php endif; ?>
                </h3>
            </div>
            <div class="card-body p-0">
                <?php if($entrevistas && count($entrevistas) > 0): ?>
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th style="width: 100px">Edad</th>
                            <th style="width: 120px">Fecha</th>
                            <th style="width: 100px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $entrevistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <span class="badge badge-primary"><?php echo e($entrevista->entrevista_codigo); ?></span>
                            </td>
                            <td><?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 50)); ?></td>
                            <td>
                                <?php if($entrevista->edad): ?>
                                    <?php echo e($entrevista->edad); ?> anos
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($entrevista->fecha_toma_inicial): ?>
                                    <?php echo e(\Carbon\Carbon::parse($entrevista->fecha_toma_inicial)->format('d/m/Y')); ?>

                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-info btn-sm" title="Ver entrevista">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('adjuntos.gestionar', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-secondary btn-sm" title="Ver adjuntos">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php else: ?>
                <div class="text-center text-muted py-4">
                    <i class="fas fa-microphone-slash fa-3x mb-3"></i>
                    <p>No hay entrevistas vinculadas a esta persona</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Acciones -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-cogs"></i> Acciones</h3>
            </div>
            <div class="card-body">
                <a href="<?php echo e(route('personas.edit', $persona->id_persona)); ?>" class="btn btn-warning btn-block mb-2">
                    <i class="fas fa-edit"></i> Editar Persona
                </a>
                <a href="<?php echo e(route('personas.index')); ?>" class="btn btn-secondary btn-block mb-2">
                    <i class="fas fa-list"></i> Ver Listado
                </a>
                <hr>
                <form action="<?php echo e(route('personas.destroy', $persona->id_persona)); ?>" method="POST" onsubmit="return confirm('Esta seguro de eliminar esta persona? Esta accion no se puede deshacer.')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger btn-block">
                        <i class="fas fa-trash"></i> Eliminar Persona
                    </button>
                </form>
            </div>
        </div>

        <!-- Info del Registro -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Informacion del Registro</h3>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">ID:</td>
                        <td><code><?php echo e($persona->id_persona); ?></code></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Creado:</td>
                        <td><?php echo e($persona->created_at ? \Carbon\Carbon::parse($persona->created_at)->format('d/m/Y H:i') : '-'); ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Actualizado:</td>
                        <td><?php echo e($persona->updated_at ? \Carbon\Carbon::parse($persona->updated_at)->format('d/m/Y H:i') : '-'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/personas/show.blade.php ENDPATH**/ ?>


<?php $__env->startSection('title', 'Ver Entrevista'); ?>
<?php $__env->startSection('content_header', 'Detalle de Entrevista'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Header -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-microphone"></i>
                    <?php echo e($entrevista->entrevista_codigo); ?>

                </h3>
                <div class="card-tools">
                    <a href="<?php echo e(route('entrevistas.wizard.edit', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="<?php echo e(route('entrevistas.index')); ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>
            <div class="card-body">
                <h4><?php echo e($entrevista->titulo); ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- PASO 1: Datos Testimoniales -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-file-alt mr-2"></i>Datos Testimoniales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 45%">Codigo:</th>
                                <td><strong><?php echo e($entrevista->entrevista_codigo); ?></strong></td>
                            </tr>
                            <tr>
                                <th>Numero:</th>
                                <td><?php echo e($entrevista->entrevista_numero); ?></td>
                            </tr>
                            <tr>
                                <th>Correlativo:</th>
                                <td><?php echo e($entrevista->entrevista_correlativo); ?></td>
                            </tr>
                            <tr>
                                <th>Dependencia Origen:</th>
                                <td><?php echo e($entrevista->rel_dependencia_origen->descripcion ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <th>Tipo Testimonio:</th>
                                <td><?php echo e($entrevista->rel_tipo_testimonio->descripcion ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <th>No. Testimoniantes:</th>
                                <td><?php echo e($entrevista->num_testimoniantes ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <th>Idioma:</th>
                                <td><?php echo e($entrevista->rel_idioma->descripcion ?? 'No especificado'); ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 45%">Entrevistador:</th>
                                <td>
                                    <?php if($entrevista->rel_entrevistador && $entrevista->rel_entrevistador->rel_usuario): ?>
                                        <?php echo e($entrevista->rel_entrevistador->rel_usuario->name); ?>

                                    <?php else: ?>
                                        <span class="text-muted">Sin asignar</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Incluye NNA:</th>
                                <td>
                                    <?php if($entrevista->nna): ?>
                                        <span class="badge badge-warning">Si</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Tiene Anexos:</th>
                                <td>
                                    <?php if($entrevista->tiene_anexos): ?>
                                        <span class="badge badge-info">Si</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php if($entrevista->descripcion_anexos): ?>
                            <tr>
                                <th>Descripcion Anexos:</th>
                                <td><?php echo e($entrevista->descripcion_anexos); ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th>Creada:</th>
                                <td><?php echo e($entrevista->created_at ? \Carbon\Carbon::parse($entrevista->created_at)->format('d/m/Y H:i') : '-'); ?></td>
                            </tr>
                            <tr>
                                <th>Actualizada:</th>
                                <td><?php echo e($entrevista->updated_at ? \Carbon\Carbon::parse($entrevista->updated_at)->format('d/m/Y H:i') : '-'); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Fecha y Lugar de Toma -->
                <hr>
                <h6><i class="fas fa-calendar-alt mr-2"></i>Fecha y Lugar de la Toma</h6>
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 45%">Fecha Inicial:</th>
                                <td><?php echo e($entrevista->fecha_toma_inicial ? \Carbon\Carbon::parse($entrevista->fecha_toma_inicial)->format('d/m/Y') : 'No especificada'); ?></td>
                            </tr>
                            <tr>
                                <th>Fecha Final:</th>
                                <td><?php echo e($entrevista->fecha_toma_final ? \Carbon\Carbon::parse($entrevista->fecha_toma_final)->format('d/m/Y') : 'No especificada'); ?></td>
                            </tr>
                            <tr>
                                <th>Virtual:</th>
                                <td>
                                    <?php if($entrevista->es_virtual): ?>
                                        <span class="badge badge-info">Si</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th style="width: 45%">Departamento:</th>
                                <td><?php echo e($depto_toma->descripcion ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <th>Municipio:</th>
                                <td><?php echo e($muni_toma->descripcion ?? 'No especificado'); ?></td>
                            </tr>
                            <tr>
                                <th>Duracion:</th>
                                <td>
                                    <?php if($entrevista->tiempo_entrevista): ?>
                                        <?php echo e($entrevista->tiempo_entrevista); ?> minutos
                                    <?php else: ?>
                                        <span class="text-muted">No especificada</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Formatos y Modalidades -->
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-file-video mr-2"></i>Formato(s) del Testimonio</h6>
                        <?php if($entrevista->rel_formatos && $entrevista->rel_formatos->count() > 0): ?>
                            <?php $__currentLoopData = $entrevista->rel_formatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formato): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-info mr-1"><?php echo e($formato->descripcion); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-handshake mr-2"></i>Modalidad(es)</h6>
                        <?php if($entrevista->rel_modalidades && $entrevista->rel_modalidades->count() > 0): ?>
                            <?php $__currentLoopData = $entrevista->rel_modalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modalidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-success mr-1"><?php echo e($modalidad->descripcion); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Areas Compatibles y Necesidades -->
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-building mr-2"></i>Areas Compatibles</h6>
                        <?php if($areas_compatibles && $areas_compatibles->count() > 0): ?>
                            <?php $__currentLoopData = $areas_compatibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-primary mr-1"><?php echo e($area); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-heart mr-2"></i>Necesidades de Reparacion</h6>
                        <?php if($entrevista->rel_necesidades_reparacion && $entrevista->rel_necesidades_reparacion->count() > 0): ?>
                            <?php $__currentLoopData = $entrevista->rel_necesidades_reparacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $necesidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="badge badge-warning mr-1"><?php echo e($necesidad->descripcion); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <span class="text-muted">No especificado</span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($entrevista->observaciones_toma): ?>
                <hr>
                <h6><i class="fas fa-sticky-note mr-2"></i>Observaciones de la Toma</h6>
                <div class="callout callout-info">
                    <?php echo nl2br(e($entrevista->observaciones_toma)); ?>

                </div>
                <?php endif; ?>

                <?php if($entrevista->anotaciones): ?>
                <hr>
                <h6><i class="fas fa-comment mr-2"></i>Anotaciones Generales</h6>
                <div class="callout callout-warning">
                    <?php echo nl2br(e($entrevista->anotaciones)); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- PASO 2: Testimoniantes -->
        <div class="card card-success card-outline">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-users mr-2"></i>Testimoniantes</h5>
            </div>
            <div class="card-body">
                <?php if($entrevista->rel_personas_entrevistadas && $entrevista->rel_personas_entrevistadas->count() > 0): ?>
                    <?php $__currentLoopData = $entrevista->rel_personas_entrevistadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $pe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card card-outline card-secondary mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-user mr-2"></i>Testimoniante #<?php echo e($index + 1); ?>:
                                <?php if($pe->rel_persona): ?>
                                    <strong><?php echo e($pe->rel_persona->nombre); ?> <?php echo e($pe->rel_persona->apellido); ?></strong>
                                    <?php if($pe->rel_persona->nombre_identitario): ?>
                                        <small class="text-muted">(<?php echo e($pe->rel_persona->nombre_identitario); ?>)</small>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin datos</span>
                                <?php endif; ?>
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if($pe->rel_persona): ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th style="width: 40%">Sexo:</th>
                                            <td><?php echo e($pe->rel_persona->rel_sexo->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Identidad de Genero:</th>
                                            <td><?php echo e($pe->rel_persona->rel_identidad->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Orientacion Sexual:</th>
                                            <td><?php echo e($pe->rel_persona->rel_orientacion->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Grupo Etnico:</th>
                                            <td><?php echo e($pe->rel_persona->rel_etnia->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th style="width: 40%">Rango Etario:</th>
                                            <td><?php echo e($pe->rel_persona->rel_rango_etario->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Edad:</th>
                                            <td><?php echo e($pe->edad ?? 'No especificada'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Discapacidad:</th>
                                            <td><?php echo e($pe->rel_persona->rel_discapacidad->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Lugar Origen:</th>
                                            <td><?php echo e($pe->rel_persona->rel_lugar_nacimiento->descripcion ?? 'No especificado'); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Poblaciones y Ocupaciones -->
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Poblacion(es):</strong>
                                    <?php if($pe->rel_persona->rel_poblaciones && $pe->rel_persona->rel_poblaciones->count() > 0): ?>
                                        <?php $__currentLoopData = $pe->rel_persona->rel_poblaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-info mr-1"><?php echo e($pob->descripcion); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Ocupacion(es):</strong>
                                    <?php if($pe->rel_persona->rel_ocupaciones && $pe->rel_persona->rel_ocupaciones->count() > 0): ?>
                                        <?php $__currentLoopData = $pe->rel_persona->rel_ocupaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ocu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-secondary mr-1"><?php echo e($ocu->descripcion); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <span class="text-muted">No especificado</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Consentimiento Informado -->
                            <?php if($pe->rel_consentimiento): ?>
                            <hr>
                            <h6><i class="fas fa-file-signature mr-2"></i>Consentimiento Informado</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-sm table-bordered">
                                        <tr>
                                            <td style="width: 50%">
                                                <strong>Tiene documento de autorizacion:</strong>
                                            </td>
                                            <td>
                                                <?php if($pe->rel_consentimiento->tiene_documento_autorizacion): ?>
                                                    <span class="badge badge-success">Si</span>
                                                <?php else: ?>
                                                    <span class="badge badge-danger">No</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if($pe->rel_consentimiento->tiene_documento_autorizacion): ?>
                                        <tr>
                                            <td><strong>Es menor de edad:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->es_menor_edad ? '<span class="badge badge-warning">Si</span>' : '<span class="badge badge-secondary">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Autoriza ser entrevistado:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->autoriza_ser_entrevistado ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Permite grabacion:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->permite_grabacion ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Permite procesamiento misional:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->permite_procesamiento_misional ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Permite uso, conservacion y consulta:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->permite_uso_conservacion_consulta ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Considera riesgo seguridad:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->considera_riesgo_seguridad ? '<span class="badge badge-danger">Si</span>' : '<span class="badge badge-secondary">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Autoriza datos personales sin anonimizar:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->autoriza_datos_personales_sin_anonimizar ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Autoriza datos sensibles sin anonimizar:</strong></td>
                                            <td><?php echo $pe->rel_consentimiento->autoriza_datos_sensibles_sin_anonimizar ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if($pe->rel_consentimiento->observaciones): ?>
                                        <tr>
                                            <td><strong>Observaciones:</strong></td>
                                            <td><?php echo e($pe->rel_consentimiento->observaciones); ?></td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>No hay testimoniantes registrados para esta entrevista.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- PASO 3: Contenido del Testimonio -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h5 class="card-title"><i class="fas fa-book mr-2"></i>Contenido del Testimonio</h5>
            </div>
            <div class="card-body">
                <?php if($entrevista->rel_contenido): ?>
                    <!-- Fechas de los hechos -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Fecha Inicial de los Hechos:</strong>
                            <?php echo e($entrevista->rel_contenido->fecha_hechos_inicial ? \Carbon\Carbon::parse($entrevista->rel_contenido->fecha_hechos_inicial)->format('d/m/Y') : 'No especificada'); ?>

                        </div>
                        <div class="col-md-6">
                            <strong>Fecha Final de los Hechos:</strong>
                            <?php echo e($entrevista->rel_contenido->fecha_hechos_final ? \Carbon\Carbon::parse($entrevista->rel_contenido->fecha_hechos_final)->format('d/m/Y') : 'No especificada'); ?>

                        </div>
                    </div>

                    <hr>
                    <h6>Caracteristicas Mencionadas en el Testimonio</h6>

                    <!-- Poblaciones y Ocupaciones -->
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <strong>Poblacion(es):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_poblaciones && $entrevista->rel_contenido->rel_poblaciones->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_poblaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-info mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Ocupacion(es):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_ocupaciones && $entrevista->rel_contenido->rel_ocupaciones->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_ocupaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-secondary mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Sexos, Identidades, Orientaciones -->
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>Sexo(s):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_sexos && $entrevista->rel_contenido->rel_sexos->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_sexos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-primary mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Identidad(es) de Genero:</strong><br>
                            <?php if($entrevista->rel_contenido->rel_identidades_genero && $entrevista->rel_contenido->rel_identidades_genero->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_identidades_genero; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-success mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Orientacion(es) Sexual(es):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_orientaciones_sexuales && $entrevista->rel_contenido->rel_orientaciones_sexuales->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_orientaciones_sexuales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-warning mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Etnias, Rangos, Discapacidades -->
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <strong>Grupo(s) Etnico(s):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_etnias && $entrevista->rel_contenido->rel_etnias->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_etnias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-info mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Rango(s) de Edad:</strong><br>
                            <?php if($entrevista->rel_contenido->rel_rangos_etarios && $entrevista->rel_contenido->rel_rangos_etarios->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_rangos_etarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-secondary mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4">
                            <strong>Discapacidad(es):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_discapacidades && $entrevista->rel_contenido->rel_discapacidades->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_discapacidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-danger mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <hr>

                    <!-- Hechos Victimizantes -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Hecho(s) Victimizante(s) y de Resistencia:</strong><br>
                            <?php if($entrevista->rel_contenido->rel_hechos_victimizantes && $entrevista->rel_contenido->rel_hechos_victimizantes->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_hechos_victimizantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-danger mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Responsables -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Responsable(s) Colectivo(s):</strong><br>
                            <?php if($entrevista->rel_contenido->rel_responsables && $entrevista->rel_contenido->rel_responsables->count() > 0): ?>
                                <?php $__currentLoopData = $entrevista->rel_contenido->rel_responsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge badge-dark mr-1 mb-1"><?php echo e($item->descripcion); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Lugares Geograficos Mencionados -->
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i>Lugar(es) Geografico(s) Mencionado(s):</strong><br>
                            <?php if(isset($lugares_mencionados) && $lugares_mencionados->count() > 0): ?>
                                <ul class="list-unstyled mt-2">
                                <?php $__currentLoopData = $lugares_mencionados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lugar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <i class="fas fa-map-pin text-danger mr-1"></i>
                                        <?php if($lugar->departamento): ?>
                                            <strong><?php echo e($lugar->departamento); ?></strong>
                                        <?php endif; ?>
                                        <?php if($lugar->municipio): ?>
                                            - <?php echo e($lugar->municipio); ?>

                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            <?php else: ?>
                                <span class="text-muted">No especificado</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($entrevista->rel_contenido->responsables_individuales): ?>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <strong>Responsable(s) Individual(es):</strong><br>
                            <div class="callout callout-warning">
                                <?php echo nl2br(e($entrevista->rel_contenido->responsables_individuales)); ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if($entrevista->rel_contenido->temas_abordados): ?>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <strong>Temas Abordados:</strong><br>
                            <div class="callout callout-info">
                                <?php echo nl2br(e($entrevista->rel_contenido->temas_abordados)); ?>

                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>No hay contenido del testimonio registrado.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Adjuntos -->
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-paperclip"></i> Archivos Adjuntos</h3>
                <div class="card-tools">
                    <a href="<?php echo e(route('adjuntos.gestionar', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-info btn-sm">
                        <i class="fas fa-cog"></i> Gestionar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if($entrevista->rel_adjuntos && $entrevista->rel_adjuntos->count() > 0): ?>
                <ul class="list-group list-group-flush">
                    <?php $__currentLoopData = $entrevista->rel_adjuntos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adjunto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <?php if($adjunto->es_audio): ?>
                                <i class="fas fa-file-audio text-info"></i>
                            <?php elseif($adjunto->es_video): ?>
                                <i class="fas fa-file-video text-danger"></i>
                            <?php elseif($adjunto->es_documento): ?>
                                <i class="fas fa-file-pdf text-warning"></i>
                            <?php else: ?>
                                <i class="fas fa-file text-secondary"></i>
                            <?php endif; ?>
                            <?php echo e(\Illuminate\Support\Str::limit($adjunto->nombre_original ?? 'Archivo', 25)); ?>

                        </span>
                        <span class="badge badge-info"><?php echo e($adjunto->fmt_tamano); ?></span>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <a href="<?php echo e(route('adjuntos.gestionar', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-outline-info btn-block btn-sm mt-2">
                    Ver todos los archivos
                </a>
                <?php else: ?>
                <p class="text-muted text-center mb-2">
                    <i class="fas fa-folder-open"></i> Sin archivos adjuntos
                </p>
                <a href="<?php echo e(route('adjuntos.gestionar', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-info btn-block btn-sm">
                    <i class="fas fa-upload"></i> Subir archivos
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Acciones -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-cogs"></i> Acciones</h3>
            </div>
            <div class="card-body">
                <a href="<?php echo e(route('entrevistas.wizard.edit', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-warning btn-block">
                    <i class="fas fa-edit"></i> Editar Entrevista
                </a>
                <form action="<?php echo e(route('entrevistas.destroy', $entrevista->id_e_ind_fvt)); ?>" method="POST" class="mt-2" onsubmit="return confirm('Esta seguro de eliminar esta entrevista?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-block">
                        <i class="fas fa-trash"></i> Eliminar Entrevista
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/entrevistas/show.blade.php ENDPATH**/ ?>
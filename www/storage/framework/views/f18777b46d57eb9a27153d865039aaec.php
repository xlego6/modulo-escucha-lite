

<?php $__env->startSection('title', 'Exportar Datos'); ?>
<?php $__env->startSection('content_header', 'Exportar Datos a Excel'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Exportar Entrevistas -->
    <div class="col-lg-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-microphone mr-2"></i>Exportar Entrevistas</h3>
            </div>
            <form action="<?php echo e(route('exportar.entrevistas')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <!-- Seccion: Filtros por Fecha -->
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3">
                                <i class="fas fa-calendar-alt mr-2"></i>Filtros por Fecha
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_desde">Fecha Desde</label>
                                <input type="date" class="form-control" id="fecha_desde" name="fecha_desde">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fecha_hasta">Fecha Hasta</label>
                                <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta">
                            </div>
                        </div>

                        <!-- Seccion: Filtros por Ubicacion y Entrevistador -->
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3 mt-2">
                                <i class="fas fa-map-marker-alt mr-2"></i>Ubicacion y Entrevistador
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_territorio">Departamento</label>
                                <select class="form-control" id="id_territorio" name="id_territorio">
                                    <?php $__currentLoopData = $territorios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_entrevistador">Entrevistador</label>
                                <select class="form-control" id="id_entrevistador" name="id_entrevistador">
                                    <?php $__currentLoopData = $entrevistadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Seccion: Filtros por Tipo de Testimonio -->
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3 mt-2">
                                <i class="fas fa-file-alt mr-2"></i>Tipo de Testimonio
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_dependencia_origen">Dependencia de Origen</label>
                                <select class="form-control" id="id_dependencia_origen" name="id_dependencia_origen">
                                    <?php $__currentLoopData = $dependencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_tipo_testimonio">Tipo de Testimonio</label>
                                <select class="form-control" id="id_tipo_testimonio" name="id_tipo_testimonio">
                                    <?php $__currentLoopData = $tipos_testimonio; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>

                        <!-- Seccion: Filtros por Adjuntos -->
                        <div class="col-12">
                            <h6 class="text-muted border-bottom pb-2 mb-3 mt-2">
                                <i class="fas fa-paperclip mr-2"></i>Filtros por Adjuntos
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tiene_adjuntos">Tiene Adjuntos</label>
                                <select class="form-control" id="tiene_adjuntos" name="tiene_adjuntos">
                                    <option value="">-- Todos --</option>
                                    <option value="1">Si - Con adjuntos</option>
                                    <option value="0">No - Sin adjuntos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_tipo_adjunto">Tipo de Adjunto</label>
                                <select class="form-control" id="id_tipo_adjunto" name="id_tipo_adjunto">
                                    <?php $__currentLoopData = $tipos_adjunto; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="form-text text-muted">Filtra entrevistas que contengan este tipo de adjunto</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-excel mr-2"></i>Descargar Excel de Entrevistas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Exportar Personas -->
    <div class="col-lg-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users mr-2"></i>Exportar Personas</h3>
            </div>
            <form action="<?php echo e(route('exportar.personas')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_sexo">Sexo</label>
                        <select class="form-control" id="id_sexo" name="id_sexo">
                            <?php $__currentLoopData = $sexos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_etnia">Grupo Etnico</label>
                        <select class="form-control" id="id_etnia" name="id_etnia">
                            <?php $__currentLoopData = $etnias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_lugar_residencia_depto">Departamento de Residencia</label>
                        <select class="form-control" id="id_lugar_residencia_depto" name="id_lugar_residencia_depto">
                            <?php $__currentLoopData = $territorios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel mr-2"></i>Descargar Excel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Contenido de los Archivos Excel</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-microphone text-primary mr-2"></i>Exportacion de Entrevistas</h6>
                        <p class="text-muted">El archivo Excel incluye los siguientes campos organizados por secciones:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Datos Tecnicos:</strong>
                                <span class="text-muted">ID, Codigo, Fecha de creacion</span>
                            </li>
                            <li class="mb-2">
                                <strong>Datos Testimoniales:</strong>
                                <span class="text-muted">Titulo, Dependencia, Tipo testimonio, Formato(s), Num. testimoniantes, Lugar de toma, Modalidad, Idioma, Fechas de toma, Necesidades reparacion, Areas compatibles, Anexos, Observaciones, Entrevistador</span>
                            </li>
                            <li class="mb-2">
                                <strong>Testimoniantes:</strong>
                                <span class="text-muted">Nombres, Tipo (victima/testigo/familiar), Estado de consentimiento</span>
                            </li>
                            <li class="mb-2">
                                <strong>Contenido:</strong>
                                <span class="text-muted">Fechas de hechos, Poblaciones mencionadas, Ocupaciones, Hechos victimizantes, Responsables colectivos e individuales, Temas abordados</span>
                            </li>
                            <li class="mb-2">
                                <strong>Adjuntos:</strong>
                                <span class="text-muted">Tiene adjuntos, Cantidad total, Tipos de adjuntos, Cantidad por tipo (audio/video/documento), Duracion total</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-users text-success mr-2"></i>Exportacion de Personas</h6>
                        <p class="text-muted">El archivo Excel incluye:</p>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Identificacion:</strong>
                                <span class="text-muted">Nombres, Apellidos, Tipo documento, Numero documento</span>
                            </li>
                            <li class="mb-2">
                                <strong>Datos personales:</strong>
                                <span class="text-muted">Fecha y lugar de nacimiento, Sexo, Etnia, Ocupacion</span>
                            </li>
                            <li class="mb-2">
                                <strong>Contacto:</strong>
                                <span class="text-muted">Lugar de residencia, Telefono, Email</span>
                            </li>
                        </ul>

                        <div class="alert alert-warning mt-4">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <strong>Nota de seguridad:</strong> Todas las exportaciones quedan registradas en la traza de actividad del sistema. Maneje la informacion con responsabilidad.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/exportar/index.blade.php ENDPATH**/ ?>
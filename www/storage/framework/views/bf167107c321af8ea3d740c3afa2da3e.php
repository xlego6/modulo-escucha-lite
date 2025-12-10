<div class="card">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-book mr-2"></i>Paso 3: Contenido del Testimonio</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle mr-2"></i>
            Esta seccion registra informacion sobre el contenido narrado en el testimonio, incluyendo poblaciones, hechos victimizantes, lugares y responsables mencionados.
        </div>

        <div class="row">
            <!-- Fechas de los hechos -->
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_hechos_inicial" class="required-field">Fecha Inicial de los Hechos</label>
                    <input type="date" class="form-control" id="fecha_hechos_inicial" name="fecha_hechos_inicial" required>
                    <small class="form-text text-muted">Fecha del hecho mas antiguo mencionado</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="fecha_hechos_final" class="required-field">Fecha Final de los Hechos</label>
                    <input type="date" class="form-control" id="fecha_hechos_final" name="fecha_hechos_final" required>
                    <small class="form-text text-muted">Fecha del hecho mas reciente mencionado</small>
                </div>
            </div>

            <!-- Poblaciones mencionadas -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Poblacion(es) Mencionada(s) en el Testimonio</label>
                    <select class="form-control select2-paso3" id="contenido_poblaciones" name="contenido_poblaciones[]" multiple>
                        <?php $__currentLoopData = $catalogos['poblaciones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Ocupaciones mencionadas -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ocupacion(es) Mencionada(s) en el Testimonio</label>
                    <select class="form-control select2-paso3" id="contenido_ocupaciones" name="contenido_ocupaciones[]" multiple>
                        <?php $__currentLoopData = $catalogos['ocupaciones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Sexos mencionados -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Sexo(s) Mencionado(s)</label>
                    <select class="form-control select2-paso3" id="contenido_sexos" name="contenido_sexos[]" multiple>
                        <?php $__currentLoopData = $catalogos['sexos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Identidades de genero mencionadas -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Identidad(es) de Genero Mencionada(s)</label>
                    <select class="form-control select2-paso3" id="contenido_identidades" name="contenido_identidades[]" multiple>
                        <?php $__currentLoopData = $catalogos['identidades_genero']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Orientaciones sexuales mencionadas -->
            <div class="col-md-4">
                <div class="form-group">
                    <label>Orientacion(es) Sexual(es) Mencionada(s)</label>
                    <select class="form-control select2-paso3" id="contenido_orientaciones" name="contenido_orientaciones[]" multiple>
                        <?php $__currentLoopData = $catalogos['orientaciones_sexuales']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Grupos etnicos mencionados -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Grupo(s) Etnico(s) Mencionado(s)</label>
                    <select class="form-control select2-paso3" id="contenido_etnias" name="contenido_etnias[]" multiple>
                        <?php $__currentLoopData = $catalogos['etnias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Rangos etarios mencionados -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Rango(s) de Edad Mencionado(s)</label>
                    <select class="form-control select2-paso3" id="contenido_rangos" name="contenido_rangos[]" multiple>
                        <?php $__currentLoopData = $catalogos['rangos_etarios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Discapacidades mencionadas -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Discapacidad(es) Mencionada(s)</label>
                    <select class="form-control select2-paso3" id="contenido_discapacidades" name="contenido_discapacidades[]" multiple>
                        <?php $__currentLoopData = $catalogos['discapacidades']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Hechos victimizantes -->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Hecho(s) Victimizante(s) y de Resistencia Mencionado(s)</label>
                    <select class="form-control select2-paso3" id="contenido_hechos" name="contenido_hechos[]" multiple>
                        <?php $__currentLoopData = $catalogos['hechos_victimizantes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Responsables colectivos -->
            <div class="col-md-12">
                <div class="form-group">
                    <label>Responsable(s) Colectivo(s) Mencionado(s)</label>
                    <select class="form-control select2-paso3" id="contenido_responsables" name="contenido_responsables[]" multiple>
                        <?php $__currentLoopData = $catalogos['responsables_colectivos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($id); ?>"><?php echo e($descripcion); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <!-- Lugares geograficos mencionados -->
            <div class="col-md-12">
                <div class="form-group">
                    <label><i class="fas fa-map-marker-alt mr-1"></i>Lugar(es) Geografico(s) Mencionado(s) en el Testimonio</label>
                    <small class="form-text text-muted mb-2">Departamentos y municipios mencionados en el testimonio. Puede agregar multiples lugares.</small>

                    <div id="lugares-mencionados-container">
                        <!-- Los lugares se agregan dinamicamente -->
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="btn-agregar-lugar">
                        <i class="fas fa-plus mr-1"></i>Agregar Lugar
                    </button>
                </div>
            </div>

            <!-- Responsables individuales -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="responsables_individuales">Responsable(s) Individual(es) Mencionado(s)</label>
                    <textarea class="form-control" id="responsables_individuales" name="responsables_individuales" rows="2" placeholder="Nombres, alias, filiaciones..."></textarea>
                    <small class="form-text text-muted">Personas especificas mencionadas con niveles de responsabilidad</small>
                </div>
            </div>

            <!-- Temas abordados -->
            <div class="col-md-12">
                <div class="form-group">
                    <label for="temas_abordados" class="required-field">Temas Abordados en el Testimonio</label>
                    <textarea class="form-control" id="temas_abordados" name="temas_abordados" rows="3" required placeholder="Ingrese los temas principales abordados..."></textarea>
                    <small class="form-text text-muted">Tematicas que aborda el testimonio segun el Tesauro de Derechos Humanos del CNMH</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/resources/views/entrevistas/wizard/partials/paso3.blade.php ENDPATH**/ ?>
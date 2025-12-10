

<?php $__env->startSection('title', 'Editar Persona'); ?>
<?php $__env->startSection('content_header', 'Editar Testimoniante'); ?>

<?php $__env->startSection('css'); ?>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
<style>
    .section-title {
        border-bottom: 2px solid #ffc107;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    .required-field::after {
        content: ' *';
        color: #dc3545;
    }
    .select2-container--bootstrap4 .select2-selection {
        min-height: calc(1.5em + 0.75rem + 2px);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('personas.update', $persona->id_persona)); ?>" method="POST" id="form-persona">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="row">
        <div class="col-md-8">
            <!-- Card Principal -->
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-edit"></i>
                        Editando: <?php echo e($persona->fmt_nombre_completo); ?>

                    </h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Por favor corrija los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Columna Izquierda -->
                        <div class="col-md-6">
                            <!-- Identificacion -->
                            <h5 class="section-title"><i class="fas fa-id-card text-warning"></i> Identificacion</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre" class="required-field">Nombre(s)</label>
                                        <input type="text" name="nombre" id="nombre"
                                            class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('nombre', $persona->nombre)); ?>" required maxlength="200">
                                        <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellido" class="required-field">Apellido(s)</label>
                                        <input type="text" name="apellido" id="apellido"
                                            class="form-control <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('apellido', $persona->apellido)); ?>" required maxlength="200">
                                        <?php $__errorArgs = ['apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nombre_identitario">Nombre Identitario</label>
                                <input type="text" name="nombre_identitario" id="nombre_identitario" class="form-control"
                                    value="<?php echo e(old('nombre_identitario', $persona->nombre_identitario)); ?>" maxlength="200">
                                <small class="form-text text-muted">Nombre con el que la persona elige ser reconocida</small>
                            </div>

                            <!-- Lugar de Origen -->
                            <h5 class="section-title mt-4"><i class="fas fa-map-marker-alt text-info"></i> Lugar de Origen</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_lugar_nacimiento_depto">Departamento</label>
                                        <select name="id_lugar_nacimiento_depto" id="id_lugar_nacimiento_depto" class="form-control">
                                            <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_lugar_nacimiento_depto', $persona->id_lugar_nacimiento_depto) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_lugar_nacimiento">Municipio</label>
                                        <select name="id_lugar_nacimiento" id="id_lugar_nacimiento" class="form-control">
                                            <option value="">-- Seleccione Departamento primero --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Poblacion -->
                            <h5 class="section-title mt-4"><i class="fas fa-users text-success"></i> Poblacion</h5>

                            <div class="form-group">
                                <label for="poblaciones">Poblacion</label>
                                <select name="poblaciones[]" id="poblaciones" class="form-control select2-multiple" multiple>
                                    <?php $__currentLoopData = $poblaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(in_array($id, $persona->rel_poblaciones->pluck('id_item')->toArray()) ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="form-text text-muted">Puede seleccionar varias opciones</small>
                            </div>

                            <!-- Ocupacion -->
                            <h5 class="section-title mt-4"><i class="fas fa-briefcase text-warning"></i> Ocupacion</h5>

                            <div class="form-group">
                                <label for="ocupaciones">Ocupacion</label>
                                <select name="ocupaciones[]" id="ocupaciones" class="form-control select2-multiple" multiple>
                                    <?php $__currentLoopData = $ocupaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(in_array($id, $persona->rel_ocupaciones->pluck('id_item')->toArray()) ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <small class="form-text text-muted">Puede seleccionar varias opciones</small>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="col-md-6">
                            <!-- Caracterizacion -->
                            <h5 class="section-title"><i class="fas fa-venus-mars text-danger"></i> Caracterizacion</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_sexo">Sexo</label>
                                        <select name="id_sexo" id="id_sexo" class="form-control">
                                            <?php $__currentLoopData = $sexos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_sexo', $persona->id_sexo) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_identidad">Identidad de Genero</label>
                                        <select name="id_identidad" id="id_identidad" class="form-control">
                                            <?php $__currentLoopData = $identidades_genero; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_identidad', $persona->id_identidad) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_orientacion">Orientacion Sexual</label>
                                        <select name="id_orientacion" id="id_orientacion" class="form-control">
                                            <?php $__currentLoopData = $orientaciones_sexuales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_orientacion', $persona->id_orientacion) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_etnia">Grupo Etnico</label>
                                        <select name="id_etnia" id="id_etnia" class="form-control">
                                            <?php $__currentLoopData = $etnias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_etnia', $persona->id_etnia) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_rango_etario">Rango Etario</label>
                                        <select name="id_rango_etario" id="id_rango_etario" class="form-control">
                                            <?php $__currentLoopData = $rangos_etarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_rango_etario', $persona->id_rango_etario) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_discapacidad">Discapacidad</label>
                                        <select name="id_discapacidad" id="id_discapacidad" class="form-control">
                                            <?php $__currentLoopData = $discapacidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_discapacidad', $persona->id_discapacidad) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Datos Adicionales (colapsable) -->
                            <div class="card card-secondary card-outline mt-4">
                                <div class="card-header p-2">
                                    <h6 class="mb-0">
                                        <a data-toggle="collapse" href="#datosAdicionales" class="text-secondary">
                                            <i class="fas fa-address-card"></i> Datos Adicionales (opcional)
                                            <i class="fas fa-chevron-down float-right"></i>
                                        </a>
                                    </h6>
                                </div>
                                <div id="datosAdicionales" class="collapse <?php echo e(($persona->num_documento || $persona->telefono || $persona->correo_electronico) ? 'show' : ''); ?>">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="id_tipo_documento">Tipo Documento</label>
                                                    <select name="id_tipo_documento" id="id_tipo_documento" class="form-control">
                                                        <?php $__currentLoopData = $tipos_documento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($id); ?>" <?php echo e(old('id_tipo_documento', $persona->id_tipo_documento) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="num_documento">Numero Documento</label>
                                                    <input type="text" name="num_documento" id="num_documento" class="form-control"
                                                        value="<?php echo e(old('num_documento', $persona->num_documento)); ?>" maxlength="50">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="telefono">Telefono</label>
                                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                                        value="<?php echo e(old('telefono', $persona->telefono)); ?>" maxlength="50">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="correo_electronico">Correo Electronico</label>
                                                    <input type="email" name="correo_electronico" id="correo_electronico" class="form-control"
                                                        value="<?php echo e(old('correo_electronico', $persona->correo_electronico)); ?>" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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

            <!-- Ayuda -->
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-question-circle"></i> Ayuda</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-2">
                        <i class="fas fa-asterisk text-danger"></i> Los campos marcados con asterisco son obligatorios.
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fas fa-lightbulb text-warning"></i> Los municipios se cargan automaticamente al seleccionar un departamento.
                    </p>
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle text-info"></i> Los campos de Poblacion y Ocupacion permiten seleccion multiple.
                    </p>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    // Inicializar Select2 para campos multiple
    $('.select2-multiple').select2({
        theme: 'bootstrap4',
        placeholder: '-- Seleccione --',
        allowClear: true
    });

    // Cargar municipios al cambiar departamento
    $('#id_lugar_nacimiento_depto').on('change', function() {
        let deptoId = $(this).val();
        let muniSelect = $('#id_lugar_nacimiento');

        if (!deptoId) {
            muniSelect.html('<option value="">-- Seleccione Departamento primero --</option>');
            return;
        }

        $.get('<?php echo e(route("api.municipios")); ?>', { id_departamento: deptoId }, function(data) {
            muniSelect.empty().append('<option value="">-- Seleccione --</option>');
            $.each(data, function(id, nombre) {
                muniSelect.append('<option value="' + id + '">' + nombre + '</option>');
            });
        });
    });

    // Cargar municipios si ya hay departamento seleccionado (para edicion)
    <?php if($persona->id_lugar_nacimiento_depto): ?>
    $.get('<?php echo e(route("api.municipios")); ?>', { id_departamento: '<?php echo e($persona->id_lugar_nacimiento_depto); ?>' }, function(data) {
        let muniSelect = $('#id_lugar_nacimiento');
        muniSelect.empty().append('<option value="">-- Seleccione --</option>');
        $.each(data, function(id, nombre) {
            muniSelect.append('<option value="' + id + '">' + nombre + '</option>');
        });
        <?php if($persona->id_lugar_nacimiento): ?>
        muniSelect.val('<?php echo e($persona->id_lugar_nacimiento); ?>');
        <?php endif; ?>
    });
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/personas/edit.blade.php ENDPATH**/ ?>
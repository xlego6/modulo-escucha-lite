

<?php $__env->startSection('title', 'Editar Entrevista'); ?>
<?php $__env->startSection('content_header', 'Editar Entrevista'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    Editando: <?php echo e($entrevista->entrevista_codigo); ?>

                </h3>
            </div>
            <form action="<?php echo e(route('entrevistas.update', $entrevista->id_e_ind_fvt)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="card-body">
                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-warning mb-3"><i class="fas fa-info-circle"></i> Informacion Basica</h5>

                            <div class="callout callout-warning">
                                <small>El codigo y numero de entrevista no pueden modificarse</small>
                                <h5 class="mb-0"><?php echo e($entrevista->entrevista_codigo); ?></h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="entrevista_fecha">Fecha de Entrevista <span class="text-danger">*</span></label>
                                        <input type="date" name="entrevista_fecha" id="entrevista_fecha"
                                            class="form-control <?php $__errorArgs = ['entrevista_fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            value="<?php echo e(old('entrevista_fecha', $entrevista->entrevista_fecha)); ?>" required>
                                        <?php $__errorArgs = ['entrevista_fecha'];
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
                                        <label for="tiempo_entrevista">Duracion (minutos)</label>
                                        <input type="number" name="tiempo_entrevista" id="tiempo_entrevista"
                                            class="form-control" value="<?php echo e(old('tiempo_entrevista', $entrevista->tiempo_entrevista)); ?>" min="1">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="titulo">Titulo <span class="text-danger">*</span></label>
                                <input type="text" name="titulo" id="titulo"
                                    class="form-control <?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('titulo', $entrevista->titulo)); ?>" required maxlength="500">
                                <?php $__errorArgs = ['titulo'];
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

                            <div class="form-group">
                                <label for="anotaciones">Anotaciones</label>
                                <textarea name="anotaciones" id="anotaciones" class="form-control" rows="3"><?php echo e(old('anotaciones', $entrevista->anotaciones)); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Entrevista Virtual</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="es_virtual_no" name="es_virtual" value="0" class="custom-control-input" <?php echo e(old('es_virtual', $entrevista->es_virtual) == 0 ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="es_virtual_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="es_virtual_si" name="es_virtual" value="1" class="custom-control-input" <?php echo e(old('es_virtual', $entrevista->es_virtual) == 1 ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="es_virtual_si">Si</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Incluye NNA</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="nna_no" name="nna" value="0" class="custom-control-input" <?php echo e(old('nna', $entrevista->nna) == 0 ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="nna_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="nna_si" name="nna" value="1" class="custom-control-input" <?php echo e(old('nna', $entrevista->nna) == 1 ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="nna_si">Si</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Interes Etnico</label>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="id_etnico_no" name="id_etnico" value="" class="custom-control-input" <?php echo e(empty(old('id_etnico', $entrevista->id_etnico)) ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="id_etnico_no">No</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="id_etnico_si" name="id_etnico" value="1" class="custom-control-input" <?php echo e(old('id_etnico', $entrevista->id_etnico) == 1 ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="id_etnico_si">Si</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="text-warning mb-3"><i class="fas fa-map-marker-alt"></i> Ubicacion y Hechos</h5>

                            <div class="form-group">
                                <label for="id_territorio">Territorio</label>
                                <select name="id_territorio" id="id_territorio" class="form-control">
                                    <?php $__currentLoopData = $territorios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('id_territorio', $entrevista->id_territorio) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="entrevista_lugar">Lugar de la Entrevista (Municipio)</label>
                                <select name="entrevista_lugar" id="entrevista_lugar" class="form-control">
                                    <?php $__currentLoopData = $municipios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('entrevista_lugar', $entrevista->entrevista_lugar) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hechos_del">Hechos Desde</label>
                                        <input type="date" name="hechos_del" id="hechos_del" class="form-control"
                                            value="<?php echo e(old('hechos_del', $entrevista->hechos_del)); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hechos_al">Hechos Hasta</label>
                                        <input type="date" name="hechos_al" id="hechos_al" class="form-control"
                                            value="<?php echo e(old('hechos_al', $entrevista->hechos_al)); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="hechos_lugar">Lugar de los Hechos (Municipio)</label>
                                <select name="hechos_lugar" id="hechos_lugar" class="form-control">
                                    <?php $__currentLoopData = $municipios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($id); ?>" <?php echo e(old('hechos_lugar', $entrevista->hechos_lugar) == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="callout callout-secondary">
                                <h6><i class="fas fa-user-tie"></i> Entrevistador</h6>
                                <p class="mb-0">
                                    <?php if($entrevista->rel_entrevistador && $entrevista->rel_entrevistador->rel_usuario): ?>
                                        <strong><?php echo e($entrevista->rel_entrevistador->rel_usuario->name); ?></strong><br>
                                        <small class="text-muted">No. <?php echo e(str_pad($entrevista->rel_entrevistador->numero_entrevistador ?? 0, 4, '0', STR_PAD_LEFT)); ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">Sin asignar</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Actualizar Entrevista
                    </button>
                    <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/entrevistas/edit.blade.php ENDPATH**/ ?>
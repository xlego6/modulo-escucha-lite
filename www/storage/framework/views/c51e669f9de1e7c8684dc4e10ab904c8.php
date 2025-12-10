

<?php $__env->startSection('title', 'Otorgar Permiso'); ?>
<?php $__env->startSection('content_header', 'Otorgar Permiso de Acceso'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <form action="<?php echo e(route('permisos.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
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
                    <div class="form-group">
                        <label for="id_entrevistador">Usuario <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['id_entrevistador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="id_entrevistador" name="id_entrevistador" required>
                            <?php $__currentLoopData = $entrevistadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_entrevistador') == $id ? 'selected' : ''); ?>><?php echo e($nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted">Seleccione el usuario que recibira el permiso</small>
                    </div>

                    <div class="form-group">
                        <label for="id_e_ind_fvt">Entrevista <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['id_e_ind_fvt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="id_e_ind_fvt" name="id_e_ind_fvt" required>
                            <?php $__currentLoopData = $entrevistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e((old('id_e_ind_fvt') == $id || $id_entrevista_preselect == $id) ? 'selected' : ''); ?>><?php echo e($descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted">Seleccione la entrevista a la que se dara acceso</small>
                    </div>

                    <div class="form-group">
                        <label for="id_tipo">Tipo de Permiso <span class="text-danger">*</span></label>
                        <select class="form-control <?php $__errorArgs = ['id_tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="id_tipo" name="id_tipo" required>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $descripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e(old('id_tipo') == $id ? 'selected' : ''); ?>><?php echo e($descripcion); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <small class="form-text text-muted">
                            <strong>Lectura:</strong> Solo ver |
                            <strong>Escritura:</strong> Ver y editar |
                            <strong>Completo:</strong> Ver, editar y eliminar
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                        <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo e(old('fecha_vencimiento')); ?>">
                        <small class="form-text text-muted">Dejar en blanco para permiso sin fecha de expiracion</small>
                    </div>

                    <div class="form-group">
                        <label for="justificacion">Justificacion <span class="text-danger">*</span></label>
                        <textarea class="form-control <?php $__errorArgs = ['justificacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="justificacion" name="justificacion" rows="4" required><?php echo e(old('justificacion')); ?></textarea>
                        <small class="form-text text-muted">Explique brevemente el motivo por el cual se otorga este permiso</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check mr-1"></i> Otorgar Permiso
            </button>
            <a href="<?php echo e(route('permisos.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-times mr-1"></i> Cancelar
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/permisos/create.blade.php ENDPATH**/ ?>
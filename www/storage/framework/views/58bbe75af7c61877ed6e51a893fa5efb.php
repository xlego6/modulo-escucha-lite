

<?php $__env->startSection('title', 'Mi Perfil'); ?>
<?php $__env->startSection('content_header', 'Mi Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Informacion del Usuario -->
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-user-img img-fluid img-circle bg-secondary d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                </div>
                <h3 class="profile-username text-center"><?php echo e($user->name); ?></h3>
                <p class="text-muted text-center"><?php echo e($user->fmt_privilegios); ?></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right"><?php echo e($user->email); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>ID Entrevistador</b> <a class="float-right"><?php echo e($user->id_entrevistador ?: 'N/A'); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Registro</b> <a class="float-right"><?php echo e($user->created_at ? $user->created_at->format('d/m/Y') : 'N/A'); ?></a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Compromiso de Reserva -->
        <div class="card card-<?php echo e($entrevistador && $entrevistador->compromiso_reserva ? 'success' : 'warning'); ?>">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shield-alt mr-2"></i>Compromiso de Reserva</h3>
            </div>
            <div class="card-body">
                <?php if($entrevistador && $entrevistador->compromiso_reserva): ?>
                    <div class="text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="mb-0"><strong>Compromiso aceptado</strong></p>
                        <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($entrevistador->compromiso_reserva)->format('d/m/Y H:i')); ?></small>
                    </div>
                <?php else: ?>
                    <p class="text-muted">
                        Para acceder a la informacion de testimonios, debe aceptar el compromiso de reserva y confidencialidad.
                    </p>
                    <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modalCompromiso">
                        <i class="fas fa-file-signature mr-2"></i>Aceptar Compromiso
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Editar Datos -->
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-edit mr-2"></i>Editar Datos</h3>
            </div>
            <form action="<?php echo e(route('perfil.actualizar')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre Completo</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $user->name)); ?>" required>
                        <?php $__errorArgs = ['name'];
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
                        <label for="email">Correo Electronico</label>
                        <?php if(Auth::user()->id_nivel <= 2): ?>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback"><?php echo e($message); ?></span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php else: ?>
                            <input type="email" class="form-control" value="<?php echo e($user->email); ?>" disabled>
                            <input type="hidden" name="email" value="<?php echo e($user->email); ?>">
                            <small class="form-text text-muted">El correo electronico no puede ser modificado. Contacte al administrador si requiere cambiarlo.</small>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-key mr-2"></i>Cambiar Contraseña</h3>
            </div>
            <form action="<?php echo e(route('perfil.password')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="password_actual">Contraseña Actual</label>
                        <input type="password" class="form-control <?php $__errorArgs = ['password_actual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password_actual" name="password_actual" required>
                        <?php $__errorArgs = ['password_actual'];
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
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Minimo 8 caracteres</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-lock mr-2"></i>Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Compromiso de Reserva -->
<div class="modal fade" id="modalCompromiso" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-file-signature mr-2"></i>Compromiso de Reserva y Confidencialidad</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('perfil.compromiso')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Lea detenidamente el siguiente compromiso antes de aceptar.
                    </div>

                    <div class="card card-body bg-light" style="max-height: 300px; overflow-y: auto;">
                        <h6>COMPROMISO DE RESERVA Y CONFIDENCIALIDAD</h6>
                        <p>Yo, <strong><?php echo e($user->name); ?></strong>, identificado(a) con el usuario <strong><?php echo e($user->email); ?></strong>, en mi calidad de usuario del Sistema de Gestion de Testimonios, me comprometo a:</p>

                        <ol>
                            <li class="mb-2"><strong>Confidencialidad:</strong> Mantener en estricta reserva toda la informacion a la que tenga acceso a traves de este sistema, incluyendo pero no limitado a: datos personales de testimoniantes, contenido de testimonios, ubicaciones, hechos narrados y cualquier otra informacion sensible.</li>

                            <li class="mb-2"><strong>Uso apropiado:</strong> Utilizar la informacion unicamente para los fines institucionales autorizados, absteniendome de copiar, reproducir, distribuir o divulgar por cualquier medio la informacion contenida en el sistema.</li>

                            <li class="mb-2"><strong>Proteccion de datos:</strong> Cumplir con las normas de proteccion de datos personales vigentes y las politicas institucionales de seguridad de la informacion.</li>

                            <li class="mb-2"><strong>No divulgacion:</strong> No revelar a terceros no autorizados ninguna informacion obtenida a traves del sistema, incluso despues de haber cesado en mis funciones.</li>

                            <li class="mb-2"><strong>Responsabilidad:</strong> Asumir la responsabilidad por cualquier uso indebido de la informacion que realice, entendiendo que el incumplimiento de este compromiso puede dar lugar a acciones disciplinarias y legales.</li>
                        </ol>

                        <p class="mb-0">Declaro que he leido, entiendo y acepto los terminos de este compromiso de reserva y confidencialidad.</p>
                    </div>

                    <div class="form-group mt-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="acepto_compromiso" name="acepto_compromiso" value="1" required>
                            <label class="custom-control-label" for="acepto_compromiso">
                                <strong>Acepto el compromiso de reserva y confidencialidad</strong>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-check mr-2"></i>Aceptar Compromiso
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/home/perfil.blade.php ENDPATH**/ ?>
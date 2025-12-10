

<?php $__env->startSection('title', 'Buscadora'); ?>
<?php $__env->startSection('content_header', 'Buscadora'); ?>

<?php $__env->startSection('css'); ?>
<style>
    .seccion-resultado {
        border-left: 4px solid #007bff;
        margin-bottom: 1rem;
    }
    .seccion-resultado.entrevistas { border-left-color: #28a745; }
    .seccion-resultado.personas { border-left-color: #17a2b8; }
    .seccion-resultado.documentos { border-left-color: #ffc107; }

    .seccion-header {
        cursor: pointer;
        user-select: none;
    }
    .seccion-header:hover {
        background-color: #f8f9fa;
    }

    .badge-coincidencia {
        font-size: 0.75rem;
        font-weight: normal;
    }

    .resultado-item {
        border-bottom: 1px solid #eee;
        padding: 0.75rem 1rem;
        transition: background-color 0.2s;
    }
    .resultado-item:hover {
        background-color: #f8f9fa;
    }
    .resultado-item:last-child {
        border-bottom: none;
    }

    .extracto-texto {
        font-size: 0.85em;
        color: #666;
        background-color: #f9f9f9;
        padding: 0.5rem;
        border-radius: 4px;
        margin-top: 0.5rem;
        max-height: 80px;
        overflow: hidden;
    }

    .icono-fuente {
        width: 24px;
        height: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        margin-right: 0.5rem;
    }
    .icono-fuente.entrevista { background-color: #d4edda; color: #28a745; }
    .icono-fuente.persona { background-color: #d1ecf1; color: #17a2b8; }
    .icono-fuente.documento { background-color: #fff3cd; color: #856404; }

    .sin-resultados {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }

    .contador-seccion {
        font-size: 0.9rem;
        font-weight: bold;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <!-- Formulario de busqueda -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-search"></i> Buscadora</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('buscador.index')); ?>">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group mb-0">
                                <div class="input-group input-group-lg">
                                    <input type="text" name="q" id="q" class="form-control"
                                        value="<?php echo e($termino); ?>"
                                        placeholder="Buscar en entrevistas, personas y documentos..."
                                        autofocus>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted mt-2">
                                    <i class="fas fa-info-circle"></i>
                                    Busca simultaneamente en: codigos y titulos de entrevistas, nombres de personas, y contenido de documentos (transcripciones, PDFs)
                                </small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <?php if($tiene_busqueda): ?>
                            <a href="<?php echo e(route('buscador.index')); ?>" class="btn btn-outline-secondary btn-lg btn-block">
                                <i class="fas fa-times"></i> Limpiar
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php if($tiene_busqueda): ?>
            <!-- Resumen de resultados -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-chart-bar"></i>
                        <strong><?php echo e($resultados['total']); ?></strong> resultado(s) encontrados para "<strong><?php echo e($termino); ?></strong>":
                        <span class="badge badge-success ml-2">
                            <i class="fas fa-microphone"></i> <?php echo e($resultados['entrevistas']->count()); ?> Entrevistas
                        </span>
                        <span class="badge badge-info ml-1">
                            <i class="fas fa-users"></i> <?php echo e($resultados['personas']->count()); ?> Personas
                        </span>
                        <span class="badge badge-warning ml-1">
                            <i class="fas fa-file-alt"></i> <?php echo e($resultados['documentos']->count()); ?> Documentos
                        </span>
                    </div>
                </div>
            </div>

            <?php if($resultados['total'] > 0): ?>
                <!-- Seccion Entrevistas -->
                <?php if($resultados['entrevistas']->count() > 0): ?>
                <div class="card seccion-resultado entrevistas">
                    <div class="card-header seccion-header" data-toggle="collapse" data-target="#seccion-entrevistas">
                        <h3 class="card-title">
                            <i class="fas fa-microphone text-success"></i>
                            Entrevistas
                            <span class="badge badge-success contador-seccion ml-2"><?php echo e($resultados['entrevistas']->count()); ?></span>
                        </h3>
                        <div class="card-tools">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="collapse show" id="seccion-entrevistas">
                        <div class="card-body p-0">
                            <?php $__currentLoopData = $resultados['entrevistas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrevista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="resultado-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="icono-fuente entrevista">
                                                <i class="fas fa-microphone"></i>
                                            </span>
                                            <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="font-weight-bold">
                                                <?php echo e($entrevista->entrevista_codigo); ?>

                                            </a>
                                            <span class="text-muted ml-2">-</span>
                                            <span class="ml-2"><?php echo e(\Illuminate\Support\Str::limit($entrevista->titulo, 60)); ?></span>
                                        </div>

                                        <div class="text-muted small">
                                            <i class="far fa-calendar"></i> <?php echo e($entrevista->entrevista_fecha ? \Carbon\Carbon::parse($entrevista->entrevista_fecha)->format('d/m/Y') : 'Sin fecha'); ?>

                                            <?php if($entrevista->rel_lugar_entrevista): ?>
                                                <span class="ml-2"><i class="fas fa-map-marker-alt"></i> <?php echo e($entrevista->rel_lugar_entrevista->descripcion); ?></span>
                                            <?php endif; ?>
                                            <?php if($entrevista->rel_entrevistador && $entrevista->rel_entrevistador->rel_usuario): ?>
                                                <span class="ml-2"><i class="fas fa-user"></i> <?php echo e($entrevista->rel_entrevistador->rel_usuario->name); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="text-muted small mt-1">
                                            <?php if($entrevista->rel_dependencia_origen): ?>
                                                <span class="badge badge-light"><i class="fas fa-building"></i> <?php echo e($entrevista->rel_dependencia_origen->descripcion); ?></span>
                                            <?php endif; ?>
                                            <?php if($entrevista->rel_equipo_estrategia): ?>
                                                <span class="badge badge-light ml-1"><i class="fas fa-users-cog"></i> <?php echo e($entrevista->rel_equipo_estrategia->descripcion); ?></span>
                                            <?php endif; ?>
                                            <?php if($entrevista->nombre_proyecto): ?>
                                                <span class="badge badge-light ml-1"><i class="fas fa-project-diagram"></i> <?php echo e(\Illuminate\Support\Str::limit($entrevista->nombre_proyecto, 30)); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Mostrar coincidencias -->
                                        <div class="mt-2">
                                            <?php if($entrevista->fuente_coincidencia === 'entrevista'): ?>
                                                <?php $__currentLoopData = $entrevista->coincidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-light badge-coincidencia">
                                                        <i class="fas fa-check-circle text-success"></i> <?php echo e($campo); ?>

                                                    </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <span class="badge badge-warning badge-coincidencia">
                                                    <i class="fas fa-file-alt"></i> Encontrado en documento(s)
                                                </span>
                                                <?php $__currentLoopData = $entrevista->coincidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="mt-1 ml-3 small">
                                                        <i class="fas fa-paperclip text-muted"></i>
                                                        <strong><?php echo e($doc['nombre']); ?></strong>
                                                        <?php if($doc['extracto']): ?>
                                                            <div class="extracto-texto"><?php echo $doc['extracto']; ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <a href="<?php echo e(route('entrevistas.show', $entrevista->id_e_ind_fvt)); ?>" class="btn btn-sm btn-outline-success">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Seccion Personas -->
                <?php if($resultados['personas']->count() > 0): ?>
                <div class="card seccion-resultado personas">
                    <div class="card-header seccion-header" data-toggle="collapse" data-target="#seccion-personas">
                        <h3 class="card-title">
                            <i class="fas fa-users text-info"></i>
                            Personas
                            <span class="badge badge-info contador-seccion ml-2"><?php echo e($resultados['personas']->count()); ?></span>
                        </h3>
                        <div class="card-tools">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="collapse show" id="seccion-personas">
                        <div class="card-body p-0">
                            <?php $__currentLoopData = $resultados['personas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $persona): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="resultado-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="icono-fuente persona">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>" class="font-weight-bold">
                                                <?php echo e($persona->nombre); ?> <?php echo e($persona->apellido); ?>

                                            </a>
                                            <?php if($persona->nombre_identitario): ?>
                                                <span class="text-muted ml-2">(<?php echo e($persona->nombre_identitario); ?>)</span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text-muted small">
                                            <?php if($persona->num_documento): ?>
                                                <span><i class="fas fa-id-card"></i> <?php echo e($persona->num_documento); ?></span>
                                            <?php endif; ?>
                                            <?php if($persona->rel_sexo): ?>
                                                <span class="ml-2"><i class="fas fa-venus-mars"></i> <?php echo e($persona->rel_sexo->descripcion); ?></span>
                                            <?php endif; ?>
                                            <?php if($persona->rel_etnia): ?>
                                                <span class="ml-2"><i class="fas fa-users"></i> <?php echo e($persona->rel_etnia->descripcion); ?></span>
                                            <?php endif; ?>
                                            <?php if($persona->num_entrevistas > 0): ?>
                                                <span class="ml-2 badge badge-secondary">
                                                    <i class="fas fa-microphone"></i> <?php echo e($persona->num_entrevistas); ?> entrevista(s)
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Mostrar coincidencias -->
                                        <div class="mt-2">
                                            <?php $__currentLoopData = $persona->coincidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge badge-light badge-coincidencia">
                                                    <i class="fas fa-check-circle text-info"></i> <?php echo e($campo); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <a href="<?php echo e(route('personas.show', $persona->id_persona)); ?>" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Seccion Documentos -->
                <?php if($resultados['documentos']->count() > 0): ?>
                <div class="card seccion-resultado documentos">
                    <div class="card-header seccion-header" data-toggle="collapse" data-target="#seccion-documentos">
                        <h3 class="card-title">
                            <i class="fas fa-file-alt text-warning"></i>
                            Documentos
                            <span class="badge badge-warning contador-seccion ml-2"><?php echo e($resultados['documentos']->count()); ?></span>
                        </h3>
                        <div class="card-tools">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="collapse show" id="seccion-documentos">
                        <div class="card-body p-0">
                            <?php $__currentLoopData = $resultados['documentos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $documento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="resultado-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="icono-fuente documento">
                                                <?php
                                                    $ext = strtolower(pathinfo($documento->nombre_original, PATHINFO_EXTENSION));
                                                    $icono = match($ext) {
                                                        'pdf' => 'fa-file-pdf',
                                                        'doc', 'docx' => 'fa-file-word',
                                                        'txt' => 'fa-file-alt',
                                                        'mp3', 'wav', 'ogg' => 'fa-file-audio',
                                                        'mp4', 'avi', 'mov' => 'fa-file-video',
                                                        'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
                                                        default => 'fa-file'
                                                    };
                                                ?>
                                                <i class="fas <?php echo e($icono); ?>"></i>
                                            </span>
                                            <span class="font-weight-bold"><?php echo e($documento->nombre_original); ?></span>
                                            <?php if($documento->rel_tipo): ?>
                                                <span class="badge badge-secondary ml-2"><?php echo e($documento->rel_tipo->descripcion); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="text-muted small">
                                            <?php if($documento->rel_entrevista): ?>
                                                <span>
                                                    <i class="fas fa-microphone"></i>
                                                    <a href="<?php echo e(route('entrevistas.show', $documento->rel_entrevista->id_e_ind_fvt)); ?>">
                                                        <?php echo e($documento->rel_entrevista->entrevista_codigo); ?>

                                                    </a>
                                                </span>
                                            <?php endif; ?>
                                            <span class="ml-2"><i class="fas fa-hdd"></i> <?php echo e(number_format($documento->tamano / 1024, 1)); ?> KB</span>
                                            <span class="ml-2"><i class="far fa-calendar"></i> <?php echo e($documento->created_at ? $documento->created_at->format('d/m/Y') : ''); ?></span>
                                        </div>

                                        <!-- Mostrar coincidencias -->
                                        <div class="mt-2">
                                            <?php $__currentLoopData = $documento->coincidencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge badge-light badge-coincidencia">
                                                    <i class="fas fa-check-circle text-warning"></i> <?php echo e($campo); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>

                                        <!-- Extracto de texto encontrado -->
                                        <?php if($documento->extracto): ?>
                                        <div class="extracto-texto mt-2">
                                            <?php echo $documento->extracto; ?>

                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-3">
                                        <?php if($documento->rel_entrevista): ?>
                                        <a href="<?php echo e(route('adjuntos.gestionar', $documento->rel_entrevista->id_e_ind_fvt)); ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-folder-open"></i> Ir
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <!-- Sin resultados -->
                <div class="card">
                    <div class="card-body sin-resultados">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h5>No se encontraron resultados</h5>
                        <p>No hay coincidencias para "<strong><?php echo e($termino); ?></strong>" en entrevistas, personas o documentos.</p>
                        <p class="small text-muted">Intente con otros terminos de busqueda.</p>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <!-- Estado inicial -->
            <div class="card">
                <div class="card-body sin-resultados">
                    <i class="fas fa-search fa-3x mb-3"></i>
                    <h5>Realice una busqueda</h5>
                    <p class="text-muted">
                        Ingrese al menos 2 caracteres para buscar en:
                    </p>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-3 text-center">
                            <div class="icono-fuente entrevista mx-auto mb-2" style="width:48px;height:48px;font-size:1.5rem;">
                                <i class="fas fa-microphone"></i>
                            </div>
                            <strong>Entrevistas</strong>
                            <p class="small text-muted">Codigos, titulos, anotaciones y contenido de documentos adjuntos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="icono-fuente persona mx-auto mb-2" style="width:48px;height:48px;font-size:1.5rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <strong>Personas</strong>
                            <p class="small text-muted">Nombres, apellidos, alias, nombres identitarios y documentos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="icono-fuente documento mx-auto mb-2" style="width:48px;height:48px;font-size:1.5rem;">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <strong>Documentos</strong>
                            <p class="small text-muted">Nombres de archivos y texto extraido de PDFs y transcripciones</p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
// Toggle icono chevron al colapsar/expandir secciones
$('.seccion-header').on('click', function() {
    var icon = $(this).find('.card-tools i');
    if ($(this).attr('aria-expanded') === 'true') {
        icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
    } else {
        icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
    }
});

// Actualizar icono cuando se colapsa/expande
$('.collapse').on('shown.bs.collapse', function() {
    $(this).prev('.seccion-header').find('.card-tools i')
        .removeClass('fa-chevron-down').addClass('fa-chevron-up');
});

$('.collapse').on('hidden.bs.collapse', function() {
    $(this).prev('.seccion-header').find('.card-tools i')
        .removeClass('fa-chevron-up').addClass('fa-chevron-down');
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/buscador/index.blade.php ENDPATH**/ ?>
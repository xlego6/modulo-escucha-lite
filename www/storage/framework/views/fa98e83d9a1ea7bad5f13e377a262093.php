

<?php $__env->startSection('title', 'Procesamientos'); ?>
<?php $__env->startSection('content_header', 'Centro de Procesamientos'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!-- Estadísticas generales -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo e(number_format($stats['total_entrevistas'])); ?></h3>
                <p>Total Entrevistas</p>
            </div>
            <div class="icon">
                <i class="fas fa-microphone"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo e(number_format($stats['transcritas'])); ?></h3>
                <p>Transcritas</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-alt"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo e(number_format($stats['con_entidades'])); ?></h3>
                <p>Con Entidades</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3><?php echo e(number_format($stats['anonimizadas'])); ?></h3>
                <p>Anonimizadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-secret"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Transcripción Automatizada -->
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-robot mr-2"></i>Transcripcion Automatizada
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Convierte archivos de audio a texto utilizando tecnologia de reconocimiento de voz (WhisperX).
                    Incluye diarizacion para identificar diferentes hablantes.
                </p>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('procesamientos.transcripcion')); ?>" class="btn btn-primary">
                    <i class="fas fa-play mr-2"></i>Iniciar Transcripcion
                </a>
            </div>
        </div>
    </div>

    <!-- Edición de Transcripciones -->
    <div class="col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-2"></i>Edicion de Transcripciones
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Revise y corrija las transcripciones automaticas. Incluye reproductor de audio sincronizado
                    con el texto para facilitar la edicion.
                </p>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('procesamientos.edicion')); ?>" class="btn btn-success">
                    <i class="fas fa-edit mr-2"></i>Editar Transcripciones
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Detección de Entidades -->
    <div class="col-md-6">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tags mr-2"></i>Deteccion de Entidades
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Identifica automaticamente personas, lugares, organizaciones, fechas y otros elementos
                    relevantes en las transcripciones usando procesamiento de lenguaje natural (spaCy).
                </p>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><span class="badge badge-primary mr-2">PER</span>Personas</li>
                            <li><span class="badge badge-success mr-2">LOC</span>Lugares</li>
                            <li><span class="badge badge-info mr-2">ORG</span>Organizaciones</li>
                            <li><span class="badge badge-secondary mr-2">DATE</span>Fechas</li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-unstyled">
                            <li><span class="badge badge-warning mr-2">EVENT</span>Eventos</li>
                            <li><span class="badge badge-danger mr-2">GUN</span>Armas</li>
                            <li><span class="badge badge-dark mr-2">MISC</span>Otros</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('procesamientos.entidades')); ?>" class="btn btn-warning">
                    <i class="fas fa-search mr-2"></i>Detectar Entidades
                </a>
            </div>
        </div>
    </div>

    <!-- Anonimización -->
    <div class="col-md-6">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-user-secret mr-2"></i>Anonimizacion
                </h3>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Genera versiones publicas de los testimonios con informacion sensible anonimizada.
                    Protege la identidad de los testimoniantes y personas mencionadas.
                </p>
            </div>
            <div class="card-footer">
                <a href="<?php echo e(route('procesamientos.anonimizacion')); ?>" class="btn btn-danger">
                    <i class="fas fa-mask mr-2"></i>Anonimizar Testimonios
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Estado de Servicios -->
<div class="row">
    <div class="col-12">
        <div class="card card-outline card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-server mr-2"></i>Estado de Servicios</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="actualizarEstadoServicios()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <span id="status-transcription" class="badge badge-secondary mr-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                            <strong>Transcripcion (WhisperX)</strong>
                        </div>
                        <small class="text-muted" id="info-transcription">Verificando...</small>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <span id="status-ner" class="badge badge-secondary mr-2">
                                <i class="fas fa-spinner fa-spin"></i>
                            </span>
                            <strong>NER / Entidades (spaCy)</strong>
                        </div>
                        <small class="text-muted" id="info-ner">Verificando...</small>
                    </div>
                </div>
                <hr>
                <p class="text-muted small mb-0">
                    <i class="fas fa-info-circle mr-1"></i>
                    Para iniciar los servicios ejecute: <code>python services/start_services.py</code>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Flujo de Trabajo -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-project-diagram mr-2"></i>Flujo de Procesamiento</h3>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-3">
                <div class="p-3 border rounded">
                    <i class="fas fa-microphone fa-3x text-primary mb-3"></i>
                    <h5>1. Audio</h5>
                    <p class="text-muted small mb-0">Entrevista grabada</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded">
                    <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                    <h5>2. Transcripcion</h5>
                    <p class="text-muted small mb-0">Audio a texto</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded">
                    <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                    <h5>3. Entidades</h5>
                    <p class="text-muted small mb-0">Identificacion NER</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border rounded">
                    <i class="fas fa-user-secret fa-3x text-danger mb-3"></i>
                    <h5>4. Anonimizacion</h5>
                    <p class="text-muted small mb-0">Version publica</p>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center">
                <i class="fas fa-arrow-right text-muted mx-4 d-none d-md-inline"></i>
                <i class="fas fa-arrow-right text-muted mx-4 d-none d-md-inline"></i>
                <i class="fas fa-arrow-right text-muted mx-4 d-none d-md-inline"></i>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    actualizarEstadoServicios();
});

function actualizarEstadoServicios() {
    $.get('<?php echo e(route("procesamientos.servicios-status")); ?>', function(data) {
        // Servicio de Transcripcion
        if (data.transcription && !data.transcription.error) {
            $('#status-transcription')
                .removeClass('badge-secondary badge-danger')
                .addClass('badge-success')
                .html('<i class="fas fa-check"></i> Activo');

            var info = 'Disponible';
            if (data.transcription.model) {
                info += ' - Modelo: ' + data.transcription.model;
            }
            if (data.transcription.device) {
                info += ' (' + data.transcription.device + ')';
            }
            $('#info-transcription').text(info);
        } else {
            $('#status-transcription')
                .removeClass('badge-secondary badge-success')
                .addClass('badge-danger')
                .html('<i class="fas fa-times"></i> Inactivo');
            $('#info-transcription').text(data.transcription?.error || 'Servicio no disponible');
        }

        // Servicio NER
        if (data.ner && !data.ner.error) {
            $('#status-ner')
                .removeClass('badge-secondary badge-danger')
                .addClass('badge-success')
                .html('<i class="fas fa-check"></i> Activo');

            var infoNer = 'Disponible';
            if (data.ner.model) {
                infoNer += ' - Modelo: ' + data.ner.model;
            }
            if (data.ner.entity_types) {
                infoNer += ' (' + data.ner.entity_types.length + ' tipos)';
            }
            $('#info-ner').text(infoNer);
        } else {
            $('#status-ner')
                .removeClass('badge-secondary badge-success')
                .addClass('badge-danger')
                .html('<i class="fas fa-times"></i> Inactivo');
            $('#info-ner').text(data.ner?.error || 'Servicio no disponible');
        }
    }).fail(function() {
        $('#status-transcription, #status-ner')
            .removeClass('badge-secondary badge-success')
            .addClass('badge-danger')
            .html('<i class="fas fa-times"></i> Error');
        $('#info-transcription, #info-ner').text('Error al verificar estado');
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/procesamientos/index.blade.php ENDPATH**/ ?>
@extends('layouts.app')

@section('title', 'Anonimizacion')
@section('content_header', 'Anonimizacion de Testimonios')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="callout callout-danger">
            <h5><i class="fas fa-user-secret mr-2"></i>Generacion de Versiones Publicas</h5>
            <p class="mb-0">
                Genera versiones anonimizadas de los testimonios para su difusion publica,
                protegiendo la identidad de testimoniantes y personas mencionadas.
            </p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list mr-2"></i>Entrevistas Pendientes de Anonimizar</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Codigo</th>
                            <th>Titulo</th>
                            <th>Archivos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendientes as $entrevista)
                        <tr>
                            <td>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input check-item"
                                           id="check{{ $entrevista->id_e_ind_fvt }}"
                                           value="{{ $entrevista->id_e_ind_fvt }}">
                                    <label class="custom-control-label" for="check{{ $entrevista->id_e_ind_fvt }}"></label>
                                </div>
                            </td>
                            <td><code>{{ $entrevista->entrevista_codigo }}</code></td>
                            <td>
                                <a href="{{ route('entrevistas.show', $entrevista->id_e_ind_fvt) }}">
                                    {{ \Illuminate\Support\Str::limit($entrevista->titulo, 35) }}
                                </a>
                            </td>
                            <td>
                                <span class="badge badge-info">
                                    {{ $entrevista->rel_adjuntos->count() }} audios
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('procesamientos.previsualizar-anonimizacion', $entrevista->id_e_ind_fvt) }}"
                                   class="btn btn-sm btn-danger" title="Previsualizar">
                                    <i class="fas fa-eye"></i> Previsualizar
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                                No hay entrevistas pendientes de anonimizar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($pendientes->hasPages())
            <div class="card-footer">
                {{ $pendientes->links() }}
            </div>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <!-- Configuración de anonimización -->
        <div class="card card-danger">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-cog mr-2"></i>Configuracion</h3>
            </div>
            <div class="card-body">
                <p class="text-muted">Seleccione los tipos de entidades a anonimizar:</p>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input tipo-anonimizar" id="tipo-PER" value="PER" checked>
                        <label class="custom-control-label" for="tipo-PER">
                            <span class="badge badge-primary">PER</span> Personas
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input tipo-anonimizar" id="tipo-LOC" value="LOC" checked>
                        <label class="custom-control-label" for="tipo-LOC">
                            <span class="badge badge-success">LOC</span> Lugares especificos
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input tipo-anonimizar" id="tipo-ORG" value="ORG">
                        <label class="custom-control-label" for="tipo-ORG">
                            <span class="badge badge-info">ORG</span> Organizaciones
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input tipo-anonimizar" id="tipo-DATE" value="DATE">
                        <label class="custom-control-label" for="tipo-DATE">
                            <span class="badge badge-secondary">DATE</span> Fechas
                        </label>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label>Formato de reemplazo:</label>
                    <select class="form-control" id="formato-reemplazo">
                        <option value="brackets">[PERSONA], [LUGAR], etc.</option>
                        <option value="asterisks">***, ####</option>
                        <option value="generic">[REDACTADO]</option>
                    </select>
                </div>

                <button class="btn btn-danger btn-block" id="btn-procesar-lote" disabled>
                    <i class="fas fa-user-secret mr-2"></i>Anonimizar Seleccionadas
                </button>
            </div>
        </div>

        <!-- Estado del Servicio -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-server mr-2"></i>Estado del Servicio</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" onclick="verificarServicio()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <span id="status-ner-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Servicio NER: <strong id="status-ner">Verificando...</strong>
                    </li>
                    <li>
                        <span id="status-anon-icon"><i class="fas fa-spinner fa-spin text-secondary mr-2"></i></span>
                        Anonimizacion: <strong id="status-anon">Verificando...</strong>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Anonimizadas recientemente -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-check-circle mr-2"></i>Anonimizadas Recientemente</h3>
            </div>
            <div class="card-body p-0">
                @if($anonimizadas->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($anonimizadas as $ent)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">{{ $ent->entrevista_codigo }}</small><br>
                            {{ \Illuminate\Support\Str::limit($ent->titulo, 25) }}
                        </div>
                        <span class="badge badge-success">
                            <i class="fas fa-check"></i>
                        </span>
                    </li>
                    @endforeach
                </ul>
                @else
                <div class="text-center text-muted py-3">
                    <p class="mb-0">No hay entrevistas anonimizadas</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Verificar estado del servicio al cargar
    verificarServicio();

    // Contador de seleccionados
    $('.check-item').on('change', function() {
        var count = $('.check-item:checked').length;
        $('#btn-procesar-lote').prop('disabled', count === 0);
    });

    // Procesar en lote
    $('#btn-procesar-lote').on('click', function() {
        var ids = [];
        $('.check-item:checked').each(function() {
            ids.push($(this).val());
        });

        if (ids.length === 0) return;

        var tipos = [];
        $('.tipo-anonimizar:checked').each(function() {
            tipos.push($(this).val());
        });

        if (!confirm('¿Generar version anonimizada de ' + ids.length + ' entrevista(s)?')) return;

        alert('Funcionalidad de procesamiento en lote pendiente de implementacion');
    });
});

function verificarServicio() {
    $.get('{{ route("procesamientos.servicios-status") }}', function(data) {
        if (data.ner && !data.ner.error) {
            // Servicio disponible
            $('#status-ner-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
            $('#status-ner').text('Disponible');

            // Anonimizacion usa el mismo servicio NER
            $('#status-anon-icon').html('<i class="fas fa-circle text-success mr-2"></i>');
            $('#status-anon').text('Disponible');

            // Habilitar botones
            $('.btn-danger:not(#btn-procesar-lote)').prop('disabled', false);
        } else {
            // Servicio no disponible
            $('#status-ner-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
            $('#status-ner').text('No disponible');
            $('#status-anon-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
            $('#status-anon').text('No disponible');

            // Deshabilitar botones (excepto los de la lista)
            $('.btn-danger').prop('disabled', true);
        }
    }).fail(function() {
        $('#status-ner-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
        $('#status-ner').text('Error de conexion');
        $('#status-anon-icon').html('<i class="fas fa-circle text-danger mr-2"></i>');
        $('#status-anon').text('Error');
    });
}
</script>
@endsection

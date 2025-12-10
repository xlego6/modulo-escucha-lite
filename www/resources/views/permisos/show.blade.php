@extends('layouts.app')

@section('title', 'Detalle de Permiso')
@section('content_header', 'Detalle del Permiso')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Informacion del Permiso</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">ID Permiso:</dt>
                    <dd class="col-sm-8">{{ $permiso->id_permiso }}</dd>

                    <dt class="col-sm-4">Tipo:</dt>
                    <dd class="col-sm-8">
                        <span class="badge badge-{{ $permiso->id_tipo == 3 ? 'danger' : ($permiso->id_tipo == 2 ? 'warning' : 'info') }}">
                            {{ $permiso->fmt_tipo }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Estado:</dt>
                    <dd class="col-sm-8">
                        @if($permiso->esta_vigente)
                            <span class="badge badge-success">Vigente</span>
                        @else
                            <span class="badge badge-secondary">Vencido</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Otorgado:</dt>
                    <dd class="col-sm-8">{{ $permiso->fecha_otorgado ? $permiso->fecha_otorgado->format('d/m/Y H:i') : 'N/A' }}</dd>

                    <dt class="col-sm-4">Vencimiento:</dt>
                    <dd class="col-sm-8">{{ $permiso->fecha_vencimiento ? $permiso->fecha_vencimiento->format('d/m/Y') : 'Sin limite' }}</dd>

                    <dt class="col-sm-4">Justificacion:</dt>
                    <dd class="col-sm-8">{{ $permiso->justificacion ?: 'No especificada' }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title">Usuario y Entrevista</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Usuario:</dt>
                    <dd class="col-sm-8">
                        @if($permiso->rel_entrevistador && $permiso->rel_entrevistador->rel_usuario)
                            {{ $permiso->rel_entrevistador->rel_usuario->name }}
                            <br><small class="text-muted">{{ $permiso->rel_entrevistador->rel_usuario->email }}</small>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Entrevista:</dt>
                    <dd class="col-sm-8">
                        @if($permiso->rel_entrevista)
                            <a href="{{ route('entrevistas.show', $permiso->id_e_ind_fvt) }}">
                                {{ $permiso->rel_entrevista->entrevista_codigo }}
                            </a>
                            <br><small class="text-muted">{{ $permiso->rel_entrevista->titulo }}</small>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </dd>

                    <dt class="col-sm-4">Otorgado por:</dt>
                    <dd class="col-sm-8">
                        @if($permiso->rel_otorgado_por && $permiso->rel_otorgado_por->rel_usuario)
                            {{ $permiso->rel_otorgado_por->rel_usuario->name }}
                        @else
                            <span class="text-muted">Sistema</span>
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-footer">
        @if($permiso->esta_vigente)
        <form action="{{ route('permisos.destroy', $permiso->id_permiso) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Esta seguro de revocar este permiso?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-ban mr-1"></i> Revocar Permiso
            </button>
        </form>
        @endif
        <a href="{{ route('permisos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>
@endsection

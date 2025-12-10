@extends('layouts.app')

@section('title', 'Edicion de Transcripciones')
@section('content_header', 'Edicion de Transcripciones')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Pendientes</span>
                <span class="info-box-number">{{ $stats['pendientes'] }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Revisadas</span>
                <span class="info-box-number">{{ $stats['revisadas'] }}</span>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-edit mr-2"></i>Transcripciones Pendientes de Revision</h3>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Titulo</th>
                    <th>Fecha</th>
                    <th>Adjuntos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendientes as $entrevista)
                <tr>
                    <td><code>{{ $entrevista->entrevista_codigo }}</code></td>
                    <td>
                        <a href="{{ route('entrevistas.show', $entrevista->id_e_ind_fvt) }}">
                            {{ \Illuminate\Support\Str::limit($entrevista->titulo, 45) }}
                        </a>
                    </td>
                    <td>
                        @if($entrevista->created_at)
                            {{ $entrevista->created_at->format('d/m/Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-info">
                            {{ $entrevista->rel_adjuntos->count() }} adjuntos
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('procesamientos.editar-transcripcion', $entrevista->id_e_ind_fvt) }}"
                           class="btn btn-sm btn-primary" title="Editar transcripcion">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('procesamientos.aprobar-transcripcion', $entrevista->id_e_ind_fvt) }}"
                              method="POST" class="d-inline" onsubmit="return confirm('¿Aprobar esta transcripcion?')">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Aprobar sin cambios">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-2x mb-2"></i><br>
                        No hay transcripciones pendientes de revision
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
@endsection

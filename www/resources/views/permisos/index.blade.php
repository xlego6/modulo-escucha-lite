@extends('layouts.app')

@section('title', 'Permisos de Acceso')
@section('content_header', 'Permisos de Acceso a Entrevistas')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <form action="{{ route('permisos.index') }}" method="GET" class="form-inline">
                    <select name="id_entrevistador" class="form-control mr-2">
                        @foreach($entrevistadores as $id => $nombre)
                        <option value="{{ $id }}" {{ request('id_entrevistador') == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                    <select name="vigente" class="form-control mr-2">
                        <option value="">-- Vigencia --</option>
                        <option value="1" {{ request('vigente') == '1' ? 'selected' : '' }}>Vigentes</option>
                        <option value="0" {{ request('vigente') == '0' ? 'selected' : '' }}>Vencidos</option>
                    </select>
                    <button type="submit" class="btn btn-default">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <a href="{{ route('permisos.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times"></i>
                    </a>
                </form>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ route('permisos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Otorgar Permiso
                </a>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Entrevista</th>
                    <th>Tipo</th>
                    <th>Otorgado</th>
                    <th>Vencimiento</th>
                    <th>Estado</th>
                    <th width="120">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permisos as $permiso)
                <tr>
                    <td>{{ $permiso->id_permiso }}</td>
                    <td>
                        @if($permiso->rel_entrevistador && $permiso->rel_entrevistador->rel_usuario)
                            {{ $permiso->rel_entrevistador->rel_usuario->name }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        @if($permiso->rel_entrevista)
                            <a href="{{ route('entrevistas.show', $permiso->id_e_ind_fvt) }}">
                                {{ $permiso->rel_entrevista->entrevista_codigo }}
                            </a>
                            <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($permiso->rel_entrevista->titulo, 30) }}</small>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $permiso->id_tipo == 3 ? 'danger' : ($permiso->id_tipo == 2 ? 'warning' : 'info') }}">
                            {{ $permiso->fmt_tipo }}
                        </span>
                    </td>
                    <td>{{ $permiso->fecha_otorgado ? $permiso->fecha_otorgado->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $permiso->fecha_vencimiento ? $permiso->fecha_vencimiento->format('d/m/Y') : 'Sin limite' }}</td>
                    <td>
                        @if($permiso->esta_vigente)
                            <span class="badge badge-success">Vigente</span>
                        @else
                            <span class="badge badge-secondary">Vencido</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('permisos.show', $permiso->id_permiso) }}" class="btn btn-sm btn-info" title="Ver">
                            <i class="fas fa-eye"></i>
                        </a>
                        <form action="{{ route('permisos.destroy', $permiso->id_permiso) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Esta seguro de revocar este permiso?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Revocar">
                                <i class="fas fa-ban"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted">No se encontraron permisos</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($permisos->hasPages())
    <div class="card-footer">
        {{ $permisos->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection

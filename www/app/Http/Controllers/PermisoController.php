<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Entrevista;
use App\Models\Entrevistador;
use App\Models\TrazaActividad;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermisoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listado de permisos otorgados
     */
    public function index(Request $request)
    {
        $query = Permiso::with([
            'rel_entrevistador.rel_usuario',
            'rel_entrevista',
            'rel_otorgado_por.rel_usuario'
        ]);

        if ($request->filled('id_entrevistador')) {
            $query->where('id_entrevistador', $request->id_entrevistador);
        }

        if ($request->filled('id_e_ind_fvt')) {
            $query->where('id_e_ind_fvt', $request->id_e_ind_fvt);
        }

        if ($request->filled('vigente')) {
            if ($request->vigente == '1') {
                $query->where(function($q) {
                    $q->whereNull('fecha_vencimiento')
                      ->orWhere('fecha_vencimiento', '>', now());
                });
            } else {
                $query->where('fecha_vencimiento', '<=', now());
            }
        }

        $permisos = $query->orderBy('created_at', 'desc')->paginate(15);

        $entrevistadores = Entrevistador::with('rel_usuario')
            ->orderBy('numero_entrevistador')
            ->get()
            ->pluck('rel_usuario.name', 'id_entrevistador')
            ->prepend('-- Todos --', '');

        return view('permisos.index', compact('permisos', 'entrevistadores'));
    }

    /**
     * Formulario para otorgar permiso
     */
    public function create(Request $request)
    {
        $entrevistadores = Entrevistador::with('rel_usuario')
            ->orderBy('numero_entrevistador')
            ->get()
            ->pluck('rel_usuario.name', 'id_entrevistador')
            ->prepend('-- Seleccione --', '');

        $entrevistas = Entrevista::where('id_activo', 1)
            ->orderBy('entrevista_codigo')
            ->get()
            ->mapWithKeys(function($e) {
                return [$e->id_e_ind_fvt => "{$e->entrevista_codigo} - {$e->titulo}"];
            })
            ->prepend('-- Seleccione --', '');

        $tipos = [
            '' => '-- Seleccione --',
            1 => 'Lectura',
            2 => 'Escritura',
            3 => 'Completo',
        ];

        // Pre-seleccionar entrevista si viene por parametro
        $id_entrevista_preselect = $request->get('entrevista');

        return view('permisos.create', compact('entrevistadores', 'entrevistas', 'tipos', 'id_entrevista_preselect'));
    }

    /**
     * Guardar nuevo permiso
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_entrevistador' => 'required|integer',
            'id_e_ind_fvt' => 'required|integer',
            'id_tipo' => 'required|in:1,2,3',
            'justificacion' => 'required|string|max:500',
        ]);

        // Validar que existan los registros
        $entrevistador = Entrevistador::find($request->id_entrevistador);
        if (!$entrevistador) {
            return redirect()->back()->withInput()->withErrors(['id_entrevistador' => 'El entrevistador seleccionado no existe.']);
        }

        $entrevista = Entrevista::find($request->id_e_ind_fvt);
        if (!$entrevista) {
            return redirect()->back()->withInput()->withErrors(['id_e_ind_fvt' => 'La entrevista seleccionada no existe.']);
        }

        $user = Auth::user();

        // Verificar si ya existe un permiso igual
        $existente = Permiso::where('id_entrevistador', $request->id_entrevistador)
            ->where('id_e_ind_fvt', $request->id_e_ind_fvt)
            ->where(function($q) {
                $q->whereNull('fecha_vencimiento')
                  ->orWhere('fecha_vencimiento', '>', now());
            })
            ->first();

        if ($existente) {
            flash('Ya existe un permiso vigente para este usuario y entrevista.')->warning();
            return redirect()->back()->withInput();
        }

        $permiso = Permiso::create([
            'id_entrevistador' => $request->id_entrevistador,
            'id_e_ind_fvt' => $request->id_e_ind_fvt,
            'id_tipo' => $request->id_tipo,
            'fecha_otorgado' => now(),
            'fecha_vencimiento' => $request->fecha_vencimiento ?: null,
            'justificacion' => $request->justificacion,
            'id_otorgado_por' => $user->id_entrevistador,
        ]);

        // Registrar traza
        TrazaActividad::create([
            'id_usuario' => $user->id,
            'accion' => 'otorgar_permiso',
            'tabla' => 'permiso',
            'id_registro' => $permiso->id_permiso,
            'descripcion' => "Permiso otorgado para entrevista {$request->id_e_ind_fvt}",
            'ip' => $request->ip(),
        ]);

        flash('Permiso otorgado exitosamente.')->success();
        return redirect()->route('permisos.index');
    }

    /**
     * Ver detalle del permiso
     */
    public function show($id)
    {
        $permiso = Permiso::with([
            'rel_entrevistador.rel_usuario',
            'rel_entrevista',
            'rel_otorgado_por.rel_usuario'
        ])->findOrFail($id);

        return view('permisos.show', compact('permiso'));
    }

    /**
     * Revocar permiso
     */
    public function destroy(Request $request, $id)
    {
        $permiso = Permiso::findOrFail($id);
        $user = Auth::user();

        // Registrar traza antes de eliminar
        TrazaActividad::create([
            'id_usuario' => $user->id,
            'accion' => 'revocar_permiso',
            'tabla' => 'permiso',
            'id_registro' => $id,
            'descripcion' => "Permiso revocado para entrevista {$permiso->id_e_ind_fvt}",
            'ip' => $request->ip(),
        ]);

        $permiso->delete();

        flash('Permiso revocado exitosamente.')->success();
        return redirect()->route('permisos.index');
    }

    /**
     * Ver permisos de una entrevista especifica
     */
    public function porEntrevista($id)
    {
        $entrevista = Entrevista::findOrFail($id);

        $permisos = Permiso::with(['rel_entrevistador.rel_usuario', 'rel_otorgado_por.rel_usuario'])
            ->where('id_e_ind_fvt', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('permisos.por_entrevista', compact('entrevista', 'permisos'));
    }

    /**
     * Ver permisos de un usuario especifico
     */
    public function porUsuario($id)
    {
        $entrevistador = Entrevistador::with('rel_usuario')->findOrFail($id);

        $permisos = Permiso::with(['rel_entrevista', 'rel_otorgado_por.rel_usuario'])
            ->where('id_entrevistador', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('permisos.por_usuario', compact('entrevistador', 'permisos'));
    }
}

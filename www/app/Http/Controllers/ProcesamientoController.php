<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use App\Models\Adjunto;
use App\Services\ProcesamientoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProcesamientoController extends Controller
{
    protected $procesamientoService;

    public function __construct(ProcesamientoService $procesamientoService)
    {
        $this->middleware('auth');
        $this->procesamientoService = $procesamientoService;
    }

    /**
     * Vista principal de procesamientos
     */
    public function index()
    {
        // Estadisticas generales
        $totalEntrevistas = Entrevista::where('id_activo', 1)->count();

        // Contar entrevistas con audio o video
        $conAudio = Adjunto::where(function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            })
            ->distinct('id_e_ind_fvt')
            ->count('id_e_ind_fvt');

        $stats = [
            'total_entrevistas' => $totalEntrevistas,
            'con_audio' => $conAudio,
            'transcritas' => 0,
            'con_entidades' => 0,
            'anonimizadas' => 0,
        ];

        // Estado de los servicios
        $servicios = $this->procesamientoService->getServicesInfo();

        return view('procesamientos.index', compact('stats', 'servicios'));
    }

    /**
     * Estado de los servicios (AJAX)
     */
    public function serviciosStatus()
    {
        return response()->json($this->procesamientoService->getServicesInfo());
    }

    /**
     * Transcripcion automatizada
     */
    public function transcripcion()
    {
        // Entrevistas con audio o video
        $entrevistas = Entrevista::where('id_activo', 1)
            ->whereHas('rel_adjuntos', function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            })
            ->with(['rel_adjuntos' => function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $enProceso = collect();

        // Estado del servicio
        $servicioStatus = $this->procesamientoService->transcriptionStatus();

        return view('procesamientos.transcripcion', compact('entrevistas', 'enProceso', 'servicioStatus'));
    }

    /**
     * Iniciar transcripcion de una entrevista
     */
    public function iniciarTranscripcion(Request $request, $id)
    {
        $entrevista = Entrevista::findOrFail($id);

        // Obtener archivos de audio o video
        $audios = Adjunto::where('id_e_ind_fvt', $id)
            ->where(function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            })
            ->get();

        if ($audios->isEmpty()) {
            return response()->json(['error' => 'No hay archivos de audio o video'], 400);
        }

        // Obtener la ruta del primer archivo de audio
        $primerAudio = $audios->first();
        $audioPath = storage_path('app/' . $primerAudio->ubicacion);

        if (!file_exists($audioPath)) {
            return response()->json(['error' => 'Archivo de audio no encontrado: ' . $audioPath], 400);
        }

        // Opciones de transcripcion
        $withDiarization = $request->input('diarizar', true);

        // Llamar al servicio de transcripcion
        $result = $this->procesamientoService->transcribe($audioPath, $withDiarization);

        if ($result['success']) {
            $texto = $result['text'] ?? '';

            // Guardar la transcripcion en la entrevista (en anotaciones por ahora)
            $entrevista->anotaciones = $texto;
            $entrevista->save();

            return response()->json([
                'success' => true,
                'message' => 'Transcripcion completada',
                'entrevista_id' => $id,
                'text_length' => strlen($texto),
                'text' => $texto,
                'speakers' => $result['speakers_count'] ?? 0
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Error desconocido'
        ], 500);
    }

    /**
     * Edicion de transcripciones
     */
    public function edicion()
    {
        $pendientes = Entrevista::where('id_activo', 1)
            ->whereHas('rel_adjuntos', function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            })
            ->with(['rel_adjuntos' => function($q) {
                $q->where('tipo_mime', 'like', '%audio%')
                  ->orWhere('tipo_mime', 'like', '%video%');
            }])
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $stats = [
            'pendientes' => $pendientes->total(),
            'revisadas' => 0,
        ];

        return view('procesamientos.edicion', compact('pendientes', 'stats'));
    }

    /**
     * Editar transcripcion especifica
     */
    public function editarTranscripcion($id)
    {
        $entrevista = Entrevista::with(['rel_adjuntos' => function($q) {
            $q->where('tipo_mime', 'like', '%audio%')
              ->orWhere('tipo_mime', 'like', '%video%');
        }])->findOrFail($id);

        return view('procesamientos.editar-transcripcion', compact('entrevista'));
    }

    /**
     * Guardar transcripcion editada
     */
    public function guardarTranscripcion(Request $request, $id)
    {
        $request->validate([
            'transcripcion' => 'required|string',
        ]);

        $entrevista = Entrevista::findOrFail($id);
        $entrevista->anotaciones = $request->transcripcion;
        $entrevista->save();

        flash('Transcripcion guardada correctamente')->success();
        return redirect()->back();
    }

    /**
     * Aprobar transcripcion
     */
    public function aprobarTranscripcion($id)
    {
        $entrevista = Entrevista::findOrFail($id);
        // Marcar como revisada (cuando tengamos el campo)

        flash('Transcripcion aprobada')->success();
        return redirect()->route('procesamientos.edicion');
    }

    /**
     * Deteccion de entidades
     */
    public function entidades()
    {
        $pendientes = Entrevista::where('id_activo', 1)
            ->whereNotNull('anotaciones')
            ->where('anotaciones', '!=', '')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $procesadas = collect();

        $tiposEntidades = [
            'PER' => 'Personas',
            'LOC' => 'Lugares',
            'ORG' => 'Organizaciones',
            'MISC' => 'Miscelaneos',
            'DATE' => 'Fechas',
            'EVENT' => 'Eventos',
            'GUN' => 'Armas',
        ];

        // Estado del servicio
        $servicioStatus = $this->procesamientoService->nerStatus();

        return view('procesamientos.entidades', compact('pendientes', 'procesadas', 'tiposEntidades', 'servicioStatus'));
    }

    /**
     * Detectar entidades en una entrevista
     */
    public function detectarEntidades($id)
    {
        $entrevista = Entrevista::findOrFail($id);

        if (empty($entrevista->anotaciones)) {
            return response()->json(['error' => 'La entrevista no tiene transcripcion'], 400);
        }

        // Llamar al servicio NER
        $result = $this->procesamientoService->detectEntities($entrevista->anotaciones);

        if ($result['success']) {
            // Guardar entidades detectadas en JSON
            // Por ahora usamos un campo existente o lo guardamos en session/cache
            session()->put("entidades_$id", $result['entities']);

            return response()->json([
                'success' => true,
                'message' => 'Entidades detectadas',
                'entrevista_id' => $id,
                'total_entidades' => $result['stats']['total'] ?? 0,
                'por_tipo' => $result['stats']['by_type'] ?? []
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Error desconocido'
        ], 500);
    }

    /**
     * Ver entidades de una entrevista
     */
    public function verEntidades($id)
    {
        $entrevista = Entrevista::findOrFail($id);

        // Intentar obtener entidades de session o detectarlas
        $entidades = session()->get("entidades_$id", []);

        if (empty($entidades) && !empty($entrevista->anotaciones)) {
            // Detectar entidades al vuelo
            $result = $this->procesamientoService->detectEntities($entrevista->anotaciones);
            if ($result['success']) {
                $entidades = $result['entities'];
                session()->put("entidades_$id", $entidades);
            }
        }

        return view('procesamientos.ver-entidades', compact('entrevista', 'entidades'));
    }

    /**
     * Anonimizacion
     */
    public function anonimizacion()
    {
        $pendientes = Entrevista::where('id_activo', 1)
            ->whereNotNull('anotaciones')
            ->where('anotaciones', '!=', '')
            ->orderBy('updated_at', 'desc')
            ->paginate(20);

        $anonimizadas = collect();

        // Estado del servicio
        $servicioStatus = $this->procesamientoService->nerStatus();

        return view('procesamientos.anonimizacion', compact('pendientes', 'anonimizadas', 'servicioStatus'));
    }

    /**
     * Generar version anonimizada
     */
    public function generarAnonimizacion(Request $request, $id)
    {
        $entrevista = Entrevista::findOrFail($id);

        if (empty($entrevista->anotaciones)) {
            return response()->json(['error' => 'La entrevista no tiene transcripcion'], 400);
        }

        // Tipos de entidades a anonimizar
        $tipos = $request->input('tipos', 'PER,LOC');
        $tiposArray = is_array($tipos) ? $tipos : explode(',', $tipos);
        $formato = $request->input('formato', 'brackets');

        // Llamar al servicio de anonimizacion
        $result = $this->procesamientoService->anonymize(
            $entrevista->anotaciones,
            $tiposArray,
            $formato
        );

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Anonimizacion completada',
                'entrevista_id' => $id,
                'original_length' => strlen($entrevista->anotaciones),
                'anonymized_length' => strlen($result['anonymized_text'] ?? ''),
                'replacements' => $result['stats']['total_replaced'] ?? 0,
                'anonymized_text' => $result['anonymized_text'] ?? ''
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => $result['error'] ?? 'Error desconocido'
        ], 500);
    }

    /**
     * Vista previa de anonimizacion
     */
    public function previsualizarAnonimizacion($id)
    {
        $entrevista = Entrevista::findOrFail($id);

        // Obtener entidades
        $entidades = session()->get("entidades_$id", []);

        if (empty($entidades) && !empty($entrevista->anotaciones)) {
            $result = $this->procesamientoService->detectEntities($entrevista->anotaciones);
            if ($result['success']) {
                $entidades = $result['entities'];
                session()->put("entidades_$id", $entidades);
            }
        }

        return view('procesamientos.previsualizar-anonimizacion', compact('entrevista', 'entidades'));
    }
}

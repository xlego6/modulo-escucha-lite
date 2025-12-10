<?php

namespace App\Http\Controllers;

use App\Models\Entrevista;
use App\Models\Geo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MapaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista principal del mapa
     */
    public function index()
    {
        return view('mapa.index');
    }

    /**
     * Datos para el mapa (AJAX)
     */
    public function datos(Request $request)
    {
        // Obtener conteo de entrevistas por departamento
        $porDepartamento = Entrevista::where('id_activo', 1)
            ->select('id_lugar_hechos_depto', DB::raw('COUNT(*) as total'))
            ->whereNotNull('id_lugar_hechos_depto')
            ->groupBy('id_lugar_hechos_depto')
            ->get();

        // Obtener información geográfica de departamentos
        $departamentos = Geo::where('nivel', 2)
            ->whereIn('id_geo', $porDepartamento->pluck('id_lugar_hechos_depto'))
            ->get()
            ->keyBy('id_geo');

        // Coordenadas aproximadas de departamentos de Colombia
        $coordenadas = $this->getCoordenadasDepartamentos();

        $datos = [];
        foreach ($porDepartamento as $item) {
            $depto = $departamentos->get($item->id_lugar_hechos_depto);
            if ($depto && isset($coordenadas[$depto->descripcion])) {
                $datos[] = [
                    'id' => $item->id_lugar_hechos_depto,
                    'nombre' => $depto->descripcion,
                    'total' => $item->total,
                    'lat' => $coordenadas[$depto->descripcion]['lat'],
                    'lng' => $coordenadas[$depto->descripcion]['lng'],
                ];
            }
        }

        // Estadísticas generales
        $estadisticas = [
            'total_entrevistas' => Entrevista::where('id_activo', 1)->count(),
            'total_departamentos' => count($datos),
            'max_entrevistas' => collect($datos)->max('total') ?? 0,
        ];

        return response()->json([
            'datos' => $datos,
            'estadisticas' => $estadisticas,
        ]);
    }

    /**
     * Detalle de un departamento (AJAX)
     */
    public function detalleDepartamento($id)
    {
        $departamento = Geo::find($id);

        if (!$departamento) {
            return response()->json(['error' => 'Departamento no encontrado'], 404);
        }

        // Entrevistas del departamento
        $entrevistas = Entrevista::where('id_activo', 1)
            ->where('id_lugar_hechos_depto', $id)
            ->with(['rel_tipo_testimonio'])
            ->select('id_e_ind_fvt', 'entrevista_codigo', 'titulo', 'id_tipo_testimonio', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Conteo por municipio
        $porMunicipio = Entrevista::where('id_activo', 1)
            ->where('id_lugar_hechos_depto', $id)
            ->select('id_lugar_hechos', DB::raw('COUNT(*) as total'))
            ->whereNotNull('id_lugar_hechos')
            ->groupBy('id_lugar_hechos')
            ->with('rel_lugar_hechos')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json([
            'departamento' => $departamento->descripcion,
            'total' => $entrevistas->count(),
            'entrevistas' => $entrevistas,
            'municipios' => $porMunicipio,
        ]);
    }

    /**
     * Coordenadas de departamentos de Colombia
     */
    private function getCoordenadasDepartamentos()
    {
        return [
            'AMAZONAS' => ['lat' => -1.0, 'lng' => -71.9],
            'ANTIOQUIA' => ['lat' => 6.5, 'lng' => -75.5],
            'ARAUCA' => ['lat' => 6.5, 'lng' => -71.0],
            'ATLANTICO' => ['lat' => 10.7, 'lng' => -74.9],
            'BOGOTA D.C.' => ['lat' => 4.6, 'lng' => -74.1],
            'BOGOTA' => ['lat' => 4.6, 'lng' => -74.1],
            'BOLIVAR' => ['lat' => 8.6, 'lng' => -74.0],
            'BOYACA' => ['lat' => 5.5, 'lng' => -73.4],
            'CALDAS' => ['lat' => 5.3, 'lng' => -75.5],
            'CAQUETA' => ['lat' => 0.9, 'lng' => -74.0],
            'CASANARE' => ['lat' => 5.3, 'lng' => -71.3],
            'CAUCA' => ['lat' => 2.5, 'lng' => -76.8],
            'CESAR' => ['lat' => 9.3, 'lng' => -73.5],
            'CHOCO' => ['lat' => 5.7, 'lng' => -76.6],
            'CORDOBA' => ['lat' => 8.3, 'lng' => -75.6],
            'CUNDINAMARCA' => ['lat' => 5.0, 'lng' => -74.0],
            'GUAINIA' => ['lat' => 2.6, 'lng' => -68.5],
            'GUAVIARE' => ['lat' => 2.0, 'lng' => -72.6],
            'HUILA' => ['lat' => 2.5, 'lng' => -75.5],
            'LA GUAJIRA' => ['lat' => 11.5, 'lng' => -72.9],
            'MAGDALENA' => ['lat' => 10.4, 'lng' => -74.4],
            'META' => ['lat' => 3.5, 'lng' => -73.0],
            'NARIÑO' => ['lat' => 1.2, 'lng' => -77.3],
            'NORTE DE SANTANDER' => ['lat' => 7.9, 'lng' => -72.5],
            'PUTUMAYO' => ['lat' => 0.4, 'lng' => -76.5],
            'QUINDIO' => ['lat' => 4.5, 'lng' => -75.7],
            'RISARALDA' => ['lat' => 4.8, 'lng' => -75.7],
            'SAN ANDRES' => ['lat' => 12.5, 'lng' => -81.7],
            'SAN ANDRES Y PROVIDENCIA' => ['lat' => 12.5, 'lng' => -81.7],
            'SANTANDER' => ['lat' => 6.6, 'lng' => -73.1],
            'SUCRE' => ['lat' => 9.0, 'lng' => -75.4],
            'TOLIMA' => ['lat' => 4.1, 'lng' => -75.2],
            'VALLE DEL CAUCA' => ['lat' => 3.8, 'lng' => -76.5],
            'VAUPES' => ['lat' => 0.2, 'lng' => -70.2],
            'VICHADA' => ['lat' => 4.4, 'lng' => -69.3],
        ];
    }
}

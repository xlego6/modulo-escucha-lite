<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EntrevistaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\AdjuntoController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\EstadisticaController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\EntrevistaWizardController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\TrazaActividadController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\ProcesamientoController;

Route::get('/', function () {
    return redirect('/login');
});

// Autenticacion
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Home y Dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/perfil', [HomeController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/actualizar', [HomeController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    Route::post('/perfil/password', [HomeController::class, 'cambiarPassword'])->name('perfil.password');
    Route::post('/perfil/compromiso', [HomeController::class, 'aceptarCompromisoReserva'])->name('perfil.compromiso');

    // Mapa
    Route::get('mapa', [MapaController::class, 'index'])->name('mapa.index');
    Route::get('mapa/datos', [MapaController::class, 'datos'])->name('mapa.datos');
    Route::get('mapa/departamento/{id}', [MapaController::class, 'detalleDepartamento'])->name('mapa.departamento');

    // API endpoints (sin restriccion de compromiso)
    Route::get('api/municipios', [ApiController::class, 'municipios'])->name('api.municipios');
    Route::get('api/tipos-testimonio', [ApiController::class, 'tiposTestimonio'])->name('api.tipos_testimonio');
    Route::get('api/buscar-personas', [ApiController::class, 'buscarPersonas'])->name('api.buscar_personas');

    // Rutas que requieren compromiso de reserva aceptado
    Route::middleware(['compromiso.reserva'])->group(function () {
        // Entrevistas
        Route::resource('entrevistas', EntrevistaController::class);

        // Entrevistas Wizard (formulario de 3 pasos)
        Route::get('entrevistas-wizard/create', [EntrevistaWizardController::class, 'create'])->name('entrevistas.wizard.create');
        Route::get('entrevistas-wizard/{id}/edit', [EntrevistaWizardController::class, 'edit'])->name('entrevistas.wizard.edit');
        Route::post('entrevistas-wizard/paso1', [EntrevistaWizardController::class, 'storePaso1'])->name('entrevistas.wizard.paso1');
        Route::post('entrevistas-wizard/paso2', [EntrevistaWizardController::class, 'storePaso2'])->name('entrevistas.wizard.paso2');
        Route::post('entrevistas-wizard/paso3', [EntrevistaWizardController::class, 'storePaso3'])->name('entrevistas.wizard.paso3');

        // Personas
        Route::resource('personas', PersonaController::class);

        // Adjuntos
        Route::get('adjuntos', [AdjuntoController::class, 'index'])->name('adjuntos.index');
        Route::get('adjuntos/gestionar/{id}', [AdjuntoController::class, 'gestionar'])->name('adjuntos.gestionar');
        Route::post('adjuntos/subir/{id}', [AdjuntoController::class, 'subir'])->name('adjuntos.subir');
        Route::get('adjuntos/descargar/{id}', [AdjuntoController::class, 'descargar'])->name('adjuntos.descargar');
        Route::get('adjuntos/ver/{id}', [AdjuntoController::class, 'ver'])->name('adjuntos.ver');
        Route::delete('adjuntos/eliminar/{id}', [AdjuntoController::class, 'eliminar'])->name('adjuntos.eliminar');

        // Buscador
        Route::get('buscador', [BuscadorController::class, 'index'])->name('buscador.index');
        Route::get('buscador/rapida', [BuscadorController::class, 'rapida'])->name('buscador.rapida');
    });

    // Estadisticas
    Route::get('estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
    Route::get('estadisticas/datos', [EstadisticaController::class, 'datos'])->name('estadisticas.datos');

    // Exportar Excel
    Route::get('exportar', [ExportController::class, 'index'])->name('exportar.index');
    Route::post('exportar/entrevistas', [ExportController::class, 'entrevistas'])->name('exportar.entrevistas');
    Route::post('exportar/personas', [ExportController::class, 'personas'])->name('exportar.personas');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Permisos de acceso
    Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index');
    Route::get('permisos/create', [PermisoController::class, 'create'])->name('permisos.create');
    Route::post('permisos', [PermisoController::class, 'store'])->name('permisos.store');
    Route::get('permisos/{id}', [PermisoController::class, 'show'])->name('permisos.show');
    Route::delete('permisos/{id}', [PermisoController::class, 'destroy'])->name('permisos.destroy');
    Route::get('permisos/entrevista/{id}', [PermisoController::class, 'porEntrevista'])->name('permisos.por_entrevista');
    Route::get('permisos/usuario/{id}', [PermisoController::class, 'porUsuario'])->name('permisos.por_usuario');

    // Catalogos
    Route::get('catalogos', [CatalogoController::class, 'index'])->name('catalogos.index');
    Route::get('catalogos/create', [CatalogoController::class, 'create'])->name('catalogos.create');
    Route::post('catalogos', [CatalogoController::class, 'store'])->name('catalogos.store');
    Route::get('catalogos/{id}', [CatalogoController::class, 'show'])->name('catalogos.show');
    Route::get('catalogos/{id}/edit', [CatalogoController::class, 'edit'])->name('catalogos.edit');
    Route::put('catalogos/{id}', [CatalogoController::class, 'update'])->name('catalogos.update');
    // Items de catalogo
    Route::get('catalogos/{id_cat}/items/create', [CatalogoController::class, 'createItem'])->name('catalogos.items.create');
    Route::post('catalogos/{id_cat}/items', [CatalogoController::class, 'storeItem'])->name('catalogos.items.store');
    Route::get('catalogos/{id_cat}/items/{id_item}/edit', [CatalogoController::class, 'editItem'])->name('catalogos.items.edit');
    Route::put('catalogos/{id_cat}/items/{id_item}', [CatalogoController::class, 'updateItem'])->name('catalogos.items.update');
    Route::post('catalogos/{id_cat}/items/{id_item}/toggle', [CatalogoController::class, 'toggleItem'])->name('catalogos.items.toggle');
    Route::post('catalogos/{id_cat}/items/reorder', [CatalogoController::class, 'reorderItems'])->name('catalogos.items.reorder');

    // Traza de actividad
    Route::get('traza', [TrazaActividadController::class, 'index'])->name('traza.index');
    Route::get('traza/estadisticas', [TrazaActividadController::class, 'estadisticas'])->name('traza.estadisticas');
    Route::get('traza/exportar', [TrazaActividadController::class, 'exportar'])->name('traza.exportar');
    Route::get('traza/{id}', [TrazaActividadController::class, 'show'])->name('traza.show');

    // Procesamientos
    Route::get('procesamientos', [ProcesamientoController::class, 'index'])->name('procesamientos.index');
    Route::get('procesamientos/servicios-status', [ProcesamientoController::class, 'serviciosStatus'])->name('procesamientos.servicios-status');
    // Transcripción
    Route::get('procesamientos/transcripcion', [ProcesamientoController::class, 'transcripcion'])->name('procesamientos.transcripcion');
    Route::post('procesamientos/transcripcion/{id}/iniciar', [ProcesamientoController::class, 'iniciarTranscripcion'])->name('procesamientos.iniciar-transcripcion');
    // Edición
    Route::get('procesamientos/edicion', [ProcesamientoController::class, 'edicion'])->name('procesamientos.edicion');
    Route::get('procesamientos/edicion/{id}', [ProcesamientoController::class, 'editarTranscripcion'])->name('procesamientos.editar-transcripcion');
    Route::post('procesamientos/edicion/{id}', [ProcesamientoController::class, 'guardarTranscripcion'])->name('procesamientos.guardar-transcripcion');
    Route::get('procesamientos/edicion/{id}/aprobar', [ProcesamientoController::class, 'aprobarTranscripcion'])->name('procesamientos.aprobar-transcripcion');
    // Entidades
    Route::get('procesamientos/entidades', [ProcesamientoController::class, 'entidades'])->name('procesamientos.entidades');
    Route::post('procesamientos/entidades/{id}/detectar', [ProcesamientoController::class, 'detectarEntidades'])->name('procesamientos.detectar-entidades');
    Route::get('procesamientos/entidades/{id}', [ProcesamientoController::class, 'verEntidades'])->name('procesamientos.ver-entidades');
    // Anonimización
    Route::get('procesamientos/anonimizacion', [ProcesamientoController::class, 'anonimizacion'])->name('procesamientos.anonimizacion');
    Route::get('procesamientos/anonimizacion/{id}/previsualizar', [ProcesamientoController::class, 'previsualizarAnonimizacion'])->name('procesamientos.previsualizar-anonimizacion');
    Route::post('procesamientos/anonimizacion/{id}', [ProcesamientoController::class, 'generarAnonimizacion'])->name('procesamientos.generar-anonimizacion');
});

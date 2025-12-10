<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Entrevista extends Model
{
    protected $table = 'esclarecimiento.e_ind_fvt';
    protected $primaryKey = 'id_e_ind_fvt';

    protected $fillable = [
        'id_subserie',
        'id_entrevistador',
        'id_macroterritorio',
        'id_territorio',
        'entrevista_codigo',
        'entrevista_numero',
        'entrevista_correlativo',
        'entrevista_fecha',
        'numero_entrevistador',
        'hechos_del',
        'hechos_al',
        'hechos_lugar',
        'entrevista_lugar',
        'anotaciones',
        'titulo',
        'nna',
        'tiempo_entrevista',
        'es_virtual',
        'id_activo',
        'id_sector',
        'id_etnico',
        // Nuevos campos Paso 1
        'id_dependencia_origen',
        'id_equipo_estrategia',
        'nombre_proyecto',
        'id_tipo_testimonio',
        'num_testimoniantes',
        'id_idioma',
        'tiene_anexos',
        'descripcion_anexos',
        'fecha_toma_inicial',
        'fecha_toma_final',
        'id_area_compatible',
        'observaciones_toma',
    ];

    protected $casts = [
        'metadatos_ce' => 'array',
        'metadatos_ca' => 'array',
        'metadatos_da' => 'array',
        'metadatos_ac' => 'array',
        'fichas_alarmas' => 'array',
        'json_etiquetado' => 'array',
    ];

    public function rel_entrevistador() {
        return $this->belongsTo(Entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }

    public function rel_adjuntos() {
        return $this->hasMany(Adjunto::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    public function rel_consentimiento() {
        return $this->hasOne(Consentimiento::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    public function rel_personas_entrevistadas() {
        return $this->hasMany(PersonaEntrevistada::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    public function rel_lugar_entrevista() {
        return $this->belongsTo(Geo::class, 'entrevista_lugar', 'id_geo');
    }

    public function rel_lugar_hechos() {
        return $this->belongsTo(Geo::class, 'hechos_lugar', 'id_geo');
    }

    // Nuevas relaciones Paso 1
    public function rel_dependencia_origen() {
        return $this->belongsTo(CatItem::class, 'id_dependencia_origen', 'id_item');
    }

    public function rel_tipo_testimonio() {
        return $this->belongsTo(CatItem::class, 'id_tipo_testimonio', 'id_item');
    }

    public function rel_idioma() {
        return $this->belongsTo(CatItem::class, 'id_idioma', 'id_item');
    }

    public function rel_area_compatible() {
        return $this->belongsTo(CatItem::class, 'id_area_compatible', 'id_item');
    }

    public function rel_equipo_estrategia() {
        return $this->belongsTo(CatItem::class, 'id_equipo_estrategia', 'id_item');
    }

    public function rel_formatos() {
        return $this->belongsToMany(CatItem::class, 'esclarecimiento.entrevista_formato', 'id_e_ind_fvt', 'id_formato', 'id_e_ind_fvt', 'id_item');
    }

    public function rel_modalidades() {
        return $this->belongsToMany(CatItem::class, 'esclarecimiento.entrevista_modalidad', 'id_e_ind_fvt', 'id_modalidad', 'id_e_ind_fvt', 'id_item');
    }

    public function rel_necesidades_reparacion() {
        return $this->belongsToMany(CatItem::class, 'esclarecimiento.entrevista_necesidad_reparacion', 'id_e_ind_fvt', 'id_necesidad', 'id_e_ind_fvt', 'id_item');
    }

    // Relación Paso 3 - Contenido
    public function rel_contenido() {
        return $this->hasOne(ContenidoTestimonio::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    public function getFmtFechaAttribute() {
        if (empty($this->entrevista_fecha)) {
            return 'Sin fecha';
        }
        try {
            $fecha = Carbon::createFromFormat('Y-m-d', $this->entrevista_fecha);
            return $fecha->format('d/m/Y');
        } catch (\Exception $e) {
            return $this->entrevista_fecha;
        }
    }

    public function getFmtCodigoAttribute() {
        return $this->entrevista_codigo ?? 'Sin código';
    }

    public function getFmtTituloAttribute() {
        return $this->titulo ?? 'Sin título';
    }

    public static function filtros_default() {
        return [
            'id_activo' => 1,
        ];
    }
}

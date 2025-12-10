<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    protected $table = 'esclarecimiento.permiso';
    protected $primaryKey = 'id_permiso';

    protected $fillable = [
        'id_entrevistador',
        'id_e_ind_fvt',
        'id_tipo',
        'fecha_otorgado',
        'fecha_vencimiento',
        'justificacion',
        'id_otorgado_por',
    ];

    protected $casts = [
        'fecha_otorgado' => 'datetime',
        'fecha_vencimiento' => 'datetime',
    ];

    public function rel_entrevistador()
    {
        return $this->belongsTo(Entrevistador::class, 'id_entrevistador', 'id_entrevistador');
    }

    public function rel_entrevista()
    {
        return $this->belongsTo(Entrevista::class, 'id_e_ind_fvt', 'id_e_ind_fvt');
    }

    public function rel_otorgado_por()
    {
        return $this->belongsTo(Entrevistador::class, 'id_otorgado_por', 'id_entrevistador');
    }

    public function rel_tipo()
    {
        return $this->belongsTo(CriterioFijo::class, 'id_tipo', 'id_opcion');
    }

    public function getEstaVigenteAttribute()
    {
        if (!$this->fecha_vencimiento) {
            return true;
        }
        return $this->fecha_vencimiento > now();
    }

    public function getFmtTipoAttribute()
    {
        $tipos = [
            1 => 'Lectura',
            2 => 'Escritura',
            3 => 'Completo',
        ];
        return $tipos[$this->id_tipo] ?? 'Lectura';
    }
}

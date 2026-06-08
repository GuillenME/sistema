<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audiencia extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'audiencias';

    protected $fillable = [
        'causa',
        'fecha',
        'hora',
        'delitos_id',
        'tipo_audiencia_id',
        'juez_id',
        'traductor_id',
        'psicologo_id',
        'salas_id',
    ];

    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime:H:i',
    ];

    /**
     * Relación: Una audiencia pertenece a un delito
     */
    public function delito()
    {
        return $this->belongsTo(Delito::class, 'delitos_id');
    }

    /**
     * Relación: Una audiencia pertenece a un tipo de audiencia
     */
    public function tipoAudiencia()
    {
        return $this->belongsTo(TipoAudiencia::class, 'tipo_audiencia_id');
    }

    /**
     * Relación: Una audiencia pertenece a un juez
     */
    public function juez()
    {
        return $this->belongsTo(Juez::class, 'juez_id');
    }

    /**
     * Relación: Una audiencia pertenece opcionalmente a un traductor
     */
    public function traductor()
    {
        return $this->belongsTo(Traductor::class, 'traductor_id');
    }

    /**
     * Relación: Una audiencia pertenece opcionalmente a un psicólogo
     */
    public function psicologo()
    {
        return $this->belongsTo(Psicologo::class, 'psicologo_id');
    }

    /**
     * Relación: Una audiencia pertenece a una sala
     */
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'salas_id');
    }

    /**
     * Relación: Una audiencia tiene muchos resúmenes
     */
    public function resumenes()
    {
        return $this->hasMany(Resumen::class, 'audiencias_id');
    }
}

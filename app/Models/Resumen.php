<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'resumen';

    protected $fillable = [
        'hora_final',
        'defensa',
        'fiscalia',
        'auxiliar',
        'victima',
        'plazo',
        'medida',
        'audiencias_id',
    ];

    protected $casts = [
        'hora_final' => 'datetime:H:i',
    ];

    /**
     * Relación: Un resumen pertenece a una audiencia
     */
    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class, 'audiencias_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    use HasFactory, Concerns\NormalizesTextAttributes;

    protected $titleCaseAttributes = ['defensa', 'fiscalia', 'auxiliar', 'victima', 'medida'];

    protected $sentenceCaseAttributes = ['hechos_ocurridos', 'observaciones'];

    public $timestamps = false;
    protected $table = 'resumen';

    protected $fillable = [
        'hora_inicio',
        'hora_final',
        'fecha_vencimiento',
        'defensa',
        'fiscalia',
        'auxiliar',
        'victima',
        'plazo',
        'medida',
        'hechos_ocurridos',
        'observaciones',
        'audiencias_id',
    ];

    protected $casts = [
        'hora_inicio' => 'datetime:H:i',
        'hora_final' => 'datetime:H:i',
        'fecha_vencimiento' => 'date',
    ];

    /**
     * Relación: Un resumen pertenece a una audiencia
     */
    public function audiencia()
    {
        return $this->belongsTo(Audiencia::class, 'audiencias_id');
    }
}

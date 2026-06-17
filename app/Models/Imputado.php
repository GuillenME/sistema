<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imputado extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'imputados';

    protected $fillable = [
        'nombre',
        'apellidos',
        'fecha_registro',
        'causa',
        'delitos_id',
    ];
    protected $casts = [
        'fecha_registro' => 'date',
    ];
    /**
     * Relacion: Un imputado puede estar en muchas audiencias
     */
    public function audiencias()
    {
        return $this->belongsToMany(Audiencia::class, 'audiencia_imputado', 'imputado_id', 'audiencia_id');
    }
    public function delito()
    {
        return $this->belongsTo(Delito::class, 'delitos_id');
    }
}

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
    ];

    /**
     * Relacion: Un imputado puede estar en muchas audiencias
     */
    public function audiencias()
    {
        return $this->belongsToMany(Audiencia::class, 'audiencia_imputado', 'imputado_id', 'audiencia_id');
    }
}

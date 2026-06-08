<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juez extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'juez';

    protected $fillable = [
        'nombre',
        'apellidos',
        'lugar',
    ];

    /**
     * Relación: Un juez tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'juez_id');
    }
}

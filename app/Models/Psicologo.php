<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Psicologo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'psicologo';

    protected $fillable = [
        'nombre',
    ];

    /**
     * Relación: Un psicólogo tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'psicologo_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAudiencia extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'tipo_audiencia';

    protected $fillable = [
        'tipo',
    ];

    /**
     * Relación: Un tipo de audiencia tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'tipo_audiencia_id');
    }
}

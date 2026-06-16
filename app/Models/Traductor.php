<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traductor extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'traductor';

    protected $fillable = [
        'nombres',
        'lengua',
    ];

    /**
     * Relación: Un traductor tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'traductor_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delito extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'delitos';

    protected $fillable = [
        'delito',
    ];

    /**
     * Relación: Un delito tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'delitos_id');
    }
}

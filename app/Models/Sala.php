<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory, Concerns\NormalizesTextAttributes;

    protected $titleCaseAttributes = ['sala'];

    public $timestamps = false;
    protected $table = 'salas';

    protected $fillable = [
        'sala',
    ];

    /**
     * Relación: Una sala tiene muchas audiencias
     */
    public function audiencias()
    {
        return $this->hasMany(Audiencia::class, 'salas_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use Concerns\NormalizesTextAttributes;

    protected $table = 'notificaciones';

    protected $sentenceCaseAttributes = ['mensaje'];

    protected $fillable = [
        'resumen_id',
        'mensaje',
        'leida',
        'atendida',
    ];

    public function resumen()
    {
        return $this->belongsTo(Resumen::class);
    }
}

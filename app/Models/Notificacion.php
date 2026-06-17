<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';

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

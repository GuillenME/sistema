<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function index()
    {
        Notificacion::where('leida', false)
            ->update([
                'leida' => true
            ]);

        $notificaciones = Notificacion::latest()->get();

        return view(
            'notificaciones.index',
            compact('notificaciones')
        );
    }

    public function atender(Notificacion $notificacion)
    {
        $notificacion->update([
            'atendida' => true
        ]);

        return back()->with(
            'success',
            'Notificación marcada como atendida.'
        );
    }
}

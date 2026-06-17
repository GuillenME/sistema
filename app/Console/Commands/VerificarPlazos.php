<?php

namespace App\Console\Commands;

use App\Models\Notificacion;
use App\Models\Resumen;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificarPlazos extends Command
{
    protected $signature = 'plazos:verificar';

    protected $description = 'Verifica plazos próximos a vencer';

    public function handle()
    {
        $resumenes = Resumen::whereNotNull('fecha_vencimiento')->get();

        foreach ($resumenes as $resumen) {

            $diasRestantes = Carbon::today()
                ->diffInDays(
                    Carbon::parse($resumen->fecha_vencimiento),
                    false
                );

            if ($diasRestantes == 2 || $diasRestantes == 1) {

                $mensaje = "El plazo del resumen #{$resumen->id} vence en {$diasRestantes} día(s).";

                $existe = Notificacion::where('resumen_id', $resumen->id)
                    ->where('mensaje', $mensaje)
                    ->exists();

                if (!$existe) {

                    Notificacion::create([
                        'resumen_id' => $resumen->id,
                        'mensaje' => $mensaje,
                        'leida' => false,
                    ]);

                    $this->info($mensaje);
                }
            }
        }

        return 0;
    }
}
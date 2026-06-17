<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Notificacion;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrap();
        View::composer('*', function ($view) {

            $notificacionesPendientes = Notificacion::where('atendida', false)
                ->latest()
                ->get();

            $view->with(
                'notificacionesPendientes',
                $notificacionesPendientes
            );
        });
    }
}

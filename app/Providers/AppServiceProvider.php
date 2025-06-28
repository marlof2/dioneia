<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Configurar timezone para Brasil
        date_default_timezone_set('America/Sao_Paulo');

        App::setLocale('pt_BR');
        Carbon::setLocale('pt_BR');
    }
}

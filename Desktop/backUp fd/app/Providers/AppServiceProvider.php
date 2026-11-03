<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gera todas as URLs (assets, rotas, redirects) a partir do APP_URL.
        // Necessário para funcionar atrás do proxy de pré-visualização (Abacus)
        // e, no deploy, basta definir APP_URL com o domínio real da hospedagem.
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));

            // Se o APP_URL for https, garante que assets/rotas usem https
            // (evita bloqueio de conteúdo misto em navegadores).
            if (str_starts_with(config('app.url'), 'https://')) {
                URL::forceScheme('https');
            }
        }
    }
}

<?php
//Provider/AppServiceProvider
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Schema::defaultStringLength(191);
    
        // Ajouter l'écouteur de requête SQL ici
        if ($this->app->environment('local')) { // Assurez-vous que cela ne s'exécute qu'en environnement de développement
            DB::listen(function ($query) {
                // Formatage de la requête SQL avec ses bindings
                $sql = str_replace("?", "'%s'", $query->sql);
                $sql = vsprintf($sql, $query->bindings);

                // Log de la requête SQL complète
                Log::debug($sql, ['time' => $query->time]);
            });
        }
    }
    
}

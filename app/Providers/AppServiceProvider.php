<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('DB', \Illuminate\Support\Facades\DB::class);
        $loader->alias('Schema', \Illuminate\Support\Facades\Schema::class);
        $loader->alias('Route', \Illuminate\Support\Facades\Route::class);
        // Ajoute ici tous les aliases dont tu as besoin
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
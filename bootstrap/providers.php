<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Service Providers
    |--------------------------------------------------------------------------
    */
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
    Modules\Photos\Providers\PhotosServiceProvider::class,

    /*
    |--------------------------------------------------------------------------
    | Package Service Providers
    |--------------------------------------------------------------------------
    */
    Nwidart\Modules\LaravelModulesServiceProvider::class,
];
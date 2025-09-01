# 📦 Installation et Configuration de `nwidart/laravel-modules` (Laravel 12.19.3)

## Prerequis

### Verifier `bootstrap/providers.php`

```php
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
```

### Verifier `app/providers/AppServiceProvider.php`

```php
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
```

## 🧰 1. Installation du package

```bash
composer require nwidart/laravel-modules
```
Laravel 12 utilise Package Discovery, donc aucun ajout manuel de provider n’est nécessaire.

## ⚙️ 2. Publication du fichier de configuration

```bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```
Crée config/modules.php pour personnaliser le comportement des modules.

## 🧱 3. Création d’un module

```bash
php artisan module:make Photos
```
Génère la structure complète dans Modules/Photos.

## 🧩 4. Vérification du fichier `module.json`

```json
"providers": [
  "Modules\\Photos\\Providers\\PhotosServiceProvider"
]
```
Assure-toi que le provider est bien déclaré.

## 🧠 5. Création manuelle du ServiceProvider (si manquant)

Chemin : `Modules/Photos/Providers/PhotosServiceProvider.php`
```php
<?php

namespace Modules\Photos\Providers;

use Illuminate\Support\ServiceProvider;

class PhotosServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Logique de registre
    }

    public function boot(): void
    {
        // Logique de démarrage
    }
}
```

## 📦 6. Vérification du composer.json

```json
"autoload": {
  "psr-4": {
    "App\\": "app/",
    "Modules\\": "Modules/"
  }
}
```
Permet à Laravel d’autoloader les classes des modules.

## 🔄 7. Rechargement de l’autoload et nettoyage

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
rm -rf bootstrap/cache/*.php
```

## 🧪 8. Création d’un modèle dans le module

```bash
php artisan module:make-model Album Photos -mfs
```
Crée le modèle `Album` avec migration, factory et seeder dans le module `Photos`.

## ✅ 9. Vérification du module

```bash
php artisan module:list
```
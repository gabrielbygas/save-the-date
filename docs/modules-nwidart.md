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

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Nwidart\Modules\Traits\PathNamespace;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PhotosServiceProvider extends ServiceProvider
{
    use PathNamespace;

    protected string $name = 'Photos';

    protected string $nameLower = 'photos';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->name, 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        // $this->commands([]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->nameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->nameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->name, 'lang'), $this->nameLower);
            $this->loadJsonTranslationsFrom(module_path($this->name, 'lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $configPath = module_path($this->name, config('modules.paths.generator.config.path'));

        if (is_dir($configPath)) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($configPath));

            foreach ($iterator as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $config = str_replace($configPath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                    $config_key = str_replace([DIRECTORY_SEPARATOR, '.php'], ['.', ''], $config);
                    $segments = explode('.', $this->nameLower.'.'.$config_key);

                    // Remove duplicated adjacent segments
                    $normalized = [];
                    foreach ($segments as $segment) {
                        if (end($normalized) !== $segment) {
                            $normalized[] = $segment;
                        }
                    }

                    $key = ($config === 'config.php') ? $this->nameLower : implode('.', $normalized);

                    $this->publishes([$file->getPathname() => config_path($config)], 'config');
                    $this->merge_config_from($file->getPathname(), $key);
                }
            }
        }
    }

    /**
     * Merge config from the given path recursively.
     */
    protected function merge_config_from(string $path, string $key): void
    {
        $existing = config($key, []);
        $module_config = require $path;

        config([$key => array_replace_recursive($existing, $module_config)]);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->nameLower);
        $sourcePath = module_path($this->name, 'Resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->nameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->nameLower);

        Blade::componentNamespace(config('modules.namespace').'\\' . $this->name . '\\View\\Components', $this->nameLower);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->nameLower)) {
                $paths[] = $path.'/modules/'.$this->nameLower;
            }
        }

        return $paths;
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
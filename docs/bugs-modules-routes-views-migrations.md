# 🐛 Bug Laravel Modules : PSR-4 & Routes non chargées (Module Photos)

## 🔍 Contexte

Lors de l'installation et de la configuration du module `Photos` avec `nwidart/laravel-modules` sous Laravel 12.19.3, plusieurs erreurs sont apparues lors de l'exécution de :

```bash
composer dump-autoload
```
## ❌ Symptômes observés

### 1. Erreurs PSR-4

```txt
Class Modules\Photos\Models\Album located in ./Modules/Photos/App/Models/Album.php does not comply with psr-4 autoloading standard
Class Modules\Photos\Providers\PhotosServiceProvider located in ./Modules/Photos/Providers/Providers/PhotosServiceProvider.php does not comply with psr-4 autoloading standard
```

### 2. Fichier de routes manquant

```txt
require(/Modules/Photos/routes/api.php): Failed to open stream: No such file or directory
```

## 🧠 Causes identifiées

- Mauvais placement des fichiers (`App/Models` au lieu de `Models`, `Providers/Providers` au lieu de `Providers`)

- Mauvais namespace dans les fichiers (`Modules\Photos\App\Models` au lieu de `Modules\Photos\Models`)

- Mauvaise casse dans le chemin des routes (`routes/api.php` au lieu de `Routes/api.php`)

- Fichier `Routes/api.php` manquant

## ✅ Résolution étape par étape

### 1. Corriger les chemins de fichiers

```bash
mv Modules/Photos/App/Models Modules/Photos/Models
mv Modules/Photos/App/Http Modules/Photos/Http
mv Modules/Photos/App/Providers Modules/Photos/Providers
mv Modules/Photos/Providers/Providers/* Modules/Photos/Providers/
rmdir Modules/Photos/Providers/Providers
```

### 2. Corriger les namespaces

Dans chaque fichier déplacé, ajuster le namespace :
```php
namespace Modules\Photos\Models;
namespace Modules\Photos\Http\Controllers;
namespace Modules\Photos\Providers;
```

### 3. Créer les fichiers de routes manquants

```bash

mkdir -p Modules/Photos/Routes
touch Modules/Photos/Routes/web.php
touch Modules/Photos/Routes/api.php
```

Ajouter une route de test dans `api.php` :
```php
use Illuminate\Support\Facades\Route;

Route::get('/photos/api/test', function () {
    return response()->json(['message' => 'API fonctionne']);
});
```

### 4. Vérifier les appels dans `RouteServiceProvider`

```php
$this->loadRoutesFrom(module_path('Photos', 'Routes/web.php'));
$this->loadRoutesFrom(module_path('Photos', 'Routes/api.php'));
```

### 5. Recharger l’autoload et nettoyer les caches

```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## ✅ Résultat attendu

- Plus aucune erreur `PSR-4`

- Routes du module Photos visibles via `php artisan route:list`

- Fichiers correctement autoloadés

- Module fonctionnel et prêt à l’usage
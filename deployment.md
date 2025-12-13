# Guide de Déploiement - Save The Date sur cPanel

## 📋 Prérequis

- Accès cPanel pour le domaine gabrielkalala.com
- SSH actif sur l'hébergement
- PHP 8.2+ (Laravel 12 requirement)
- Composer installé sur le serveur
- Node.js et npm installés (pour la compilation des assets)
- Base de données MySQL disponible

---

## 🚀 Étapes de Déploiement

### ÉTAPE 1: Créer le Sous-Domaine dans cPanel

1. **Accédez à cPanel**
   - URL: `https://gabrielkalala.com:2083` (ou votre URL cPanel)
   - Connectez-vous avec vos identifiants

2. **Naviguer vers "Addon Domains" ou "Subdomains"**
   - Cherchez `Addon Domains` ou `Subdomains` dans cPanel
   - Cliquez sur `Subdomains`

3. **Créer le sous-domaine**
   - **Subdomain**: `savethedate`
   - **Domain**: `gabrielkalala.com`
   - **Document Root**: `/home/username/public_html/savethedate` (à créer)
   - Cliquez sur **Create**

4. **Notez le chemin complet du répertoire**
   - cPanel affichera quelque chose comme: `/home/gabrielkala/public_html/savethedate`
   - Utilisez ce chemin pour les étapes suivantes (remplacez `gabrielkala` par votre username)

---

### ÉTAPE 2: Préparer le Répertoire sur le Serveur

1. **Se connecter en SSH**
   ```bash
   ssh username@gabrielkalala.com
   # Remplacez username par votre username cPanel
   ```

2. **Créer la structure de répertoires**
   ```bash
   cd ~/public_html
   mkdir -p savethedate
   cd savethedate
   ```

3. **Vérifier que vous êtes au bon endroit**
   ```bash
   pwd
   # Vous devez voir: /home/username/public_html/savethedate
   ```

---

### ÉTAPE 3: Cloner ou Transférer le Projet

**Option A: Cloner depuis Git** (recommandé)
```bash
# Dans le répertoire ~/public_html/savethedate
git clone https://votre-repo-git.git .
# Ou si vous avez déjà le dépôt:
git pull origin main
```

**Option B: Transférer les fichiers via SFTP**
- Utilisez FileZilla ou WinSCP
- Uploader tous les fichiers dans `/home/username/public_html/savethedate`
- Assurez-vous que les fichiers cachés (`.env`, `.gitignore`) sont transférés

---

### ÉTAPE 4: Configuration de l'Environnement

1. **Copier et configurer le fichier .env**
   ```bash
   cp .env.example .env
   nano .env
   ```

2. **Modifier les paramètres critiques dans .env**
   ```ini
   APP_NAME="Save The Date"
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://savethedate.gabrielkalala.com

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=username_savethedate
   DB_USERNAME=username_savethedate_user
   DB_PASSWORD=votre_mot_de_passe_securise

   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gabrielkalala.com
   MAIL_PORT=465
   MAIL_USERNAME=dev@gabrielkalala.com
   MAIL_PASSWORD=votre_mot_de_passe_email
   MAIL_ENCRYPTION=ssl
   MAIL_FROM_ADDRESS=dev@gabrielkalala.com
   MAIL_FROM_NAME="Save The Date"

   # BCC emails
   MAIL_BCC_RECIPIENTS=dev@gabrielkalala.com,web@gabrielkalala.com

   QUEUE_CONNECTION=database
   CACHE_DRIVER=file
   ```

3. **Générer la clé d'application**
   ```bash
   php artisan key:generate
   ```

---

### ÉTAPE 5: Créer la Base de Données

1. **Via cPanel (PhpMyAdmin)**
   - Accédez à `PhpMyAdmin` dans cPanel
   - Créez une nouvelle base de données: `username_savethedate`
   - Créez un utilisateur: `username_savethedate_user`
   - Assignez tous les privilèges à l'utilisateur pour cette base

2. **Ou via SSH (SQL directement)**
   ```bash
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE username_savethedate;
   CREATE USER 'username_savethedate_user'@'localhost' IDENTIFIED BY 'mot_de_passe_securise';
   GRANT ALL PRIVILEGES ON username_savethedate.* TO 'username_savethedate_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

---

### ÉTAPE 6: Installer les Dépendances PHP

```bash
# Dans ~/public_html/savethedate
cd ~/public_html/savethedate

# Installer Composer (s'il n'est pas déjà installé)
curl -sS https://getcomposer.org/installer | php

# Installer les dépendances
php composer.phar install --optimize-autoloader --no-dev
# OU si composer est déjà dans le PATH:
composer install --optimize-autoloader --no-dev
```

---

### ÉTAPE 7: Installer les Dépendances Node.js et Compiler Assets

```bash
# Installer les dépendances Node.js
npm install

# Compiler les assets pour la production
npm run build
```

---

### ÉTAPE 8: Exécuter les Migrations et Seeders

```bash
# Exécuter les migrations
php artisan migrate --force

# (Optionnel) Charger les seeders
php artisan db:seed --force
```

---

### ÉTAPE 9: Créer les Liens de Stockage

```bash
# Créer le lien symbolique pour le stockage public
php artisan storage:link

# Vérifier que le lien a été créé
ls -la public/
# Vous devez voir: storage -> ../storage/app/public
```

---

### ÉTAPE 10: Configurer les Permissions des Fichiers

```bash
# Se mettre en tant qu'utilisateur root temporairement
sudo -i
# OU se connecter directement en root (si possible)

# Naviguez au répertoire du projet
cd /home/username/public_html/savethedate

# Définir les permissions
chmod -R 755 .
chmod -R 777 storage bootstrap/cache

# Définir le propriétaire correct
chown -R nobody:nobody .
# OU
chown -R username:username .
# (où username est votre username cPanel)

# Sortir du mode root
exit
```

---

### ÉTAPE 11: Configurer le SSL/TLS

1. **Vérifier que le SSL est activé dans cPanel**
   - Allez à `SSL/TLS Status` dans cPanel
   - Sélectionnez `savethedate.gabrielkalala.com`
   - Installez un certificat **Let's Encrypt** (gratuit)

2. **Forcer HTTPS dans .env** (optionnel mais recommandé)
   ```ini
   APP_URL=https://savethedate.gabrielkalala.com
   SESSION_SECURE_COOKIES=true
   ```

3. **Configurer la redirection HTTP → HTTPS**
   - Éditer le fichier `.htaccess` dans `/public`:
   ```apache
   <IfModule mod_rewrite.c>
       <IfModule mod_negotiation.c>
           Options -MultiViews -Indexes
       </IfModule>

       RewriteEngine On

       # Force HTTPS
       RewriteCond %{HTTPS} off
       RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

       # Handle Authorization Header
       RewriteCond %{HTTP:Authorization} .
       RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

       # Redirect Trailing Slashes If Not A Folder...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_URI} (.+)/$
       RewriteRule ^ %1 [L,R=301]

       # Send Requests To Front Controller...
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteRule ^ index.php [L]
   </IfModule>
   ```

---

### ÉTAPE 12: Configurer les Tâches Planifiées (Cron Jobs)

Laravel nécessite une tâche cron pour exécuter le planificateur:

1. **Accédez à cPanel → Cron Jobs**
2. **Ajouter une tâche cron**
   - **Command**: 
   ```bash
   php /home/username/public_html/savethedate/artisan schedule:run >> /dev/null 2>&1
   ```
   - **Common Settings**: `* * * * *` (chaque minute)

3. **Tâche optionnelle pour les files d'attente (queue)**
   - **Command**:
   ```bash
   php /home/username/public_html/savethedate/artisan queue:work --once >> /dev/null 2>&1
   ```
   - **Common Settings**: `*/1 * * * *` (chaque minute)

---

### ÉTAPE 13: Tester le Déploiement

1. **Vérifier l'accès au site**
   ```bash
   curl https://savethedate.gabrielkalala.com
   ```

2. **Vérifier les logs en cas d'erreur**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Vérifier la page d'accueil**
   - Ouvrez votre navigateur
   - Allez à `https://savethedate.gabrielkalala.com`
   - Vérifiez que la page charge correctement

---

## 🔧 Troubleshooting Commun

### Erreur 500
1. Vérifier les logs: `cat storage/logs/laravel.log`
2. Vérifier les permissions: `ls -la storage/`
3. Vérifier la connexion DB: `php artisan tinker` puis `DB::connection()->getPdo()`

### Erreur "Class not found"
```bash
composer dump-autoload
php artisan cache:clear
php artisan config:clear
```

### Assets non chargés (CSS/JS)
```bash
npm run build
php artisan cache:clear
```

### Base de données vide
```bash
php artisan migrate:fresh --seed
```

### Permissions refusées
```bash
chmod -R 755 .
chmod -R 777 storage bootstrap/cache
chown -R nobody:nobody .
```

---

## 📧 Configuration des Emails

Le projet envoie des emails vers:
- `dev@gabrielkalala.com`
- `web@gabrielkalala.com` (en BCC)

Assurez-vous que:
1. SMTP est correctement configuré dans `.env`
2. Les adresses email existent sur votre serveur
3. Le firewall n'est pas en conflit (port 465 pour SSL)

---

## 🔒 Checklist de Sécurité

- [ ] Changer `APP_DEBUG=false` en production
- [ ] Générer une clé d'application unique avec `php artisan key:generate`
- [ ] Configurer un mot de passe de base de données fort
- [ ] Installer un certificat SSL/TLS
- [ ] Configurer les permissions des fichiers (`chmod` et `chown`)
- [ ] Configurer les fichiers `.env` avec les bonnes valeurs
- [ ] Activer les logs et les monitorer régulièrement
- [ ] Configurer les sauvegardes automatiques de la base de données

---

## 📝 Commandes Utiles Post-Déploiement

```bash
# Vérifier l'état de l'application
php artisan tinker
php artisan migrate:status
php artisan db:seed --force
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Mettre à jour après un git pull
git pull origin main
composer install --optimize-autoloader --no-dev
npm install && npm run build
php artisan migrate --force
```

---

## 📞 Support et Ressources

- Documentation Laravel: https://laravel.com/docs/12
- cPanel Documentation: https://documentation.cpanel.net/
- Let's Encrypt SSL: https://letsencrypt.org/

---

**Date de création**: 2025-12-13  
**Projet**: Save The Date - Wedding Visuals Platform

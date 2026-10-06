#!/usr/bin/env bash
# Recovery/setup script for the Penida Gili Laravel app in this preview pod.
# The PHP runtime and supervisor program live OUTSIDE /app, so a pod restart
# (after inactivity) can wipe them. Re-run this script to bring the app back up.
set -e
cd /app

echo "==> Installing PHP 8.4 + Composer (if missing)"
if ! command -v php >/dev/null 2>&1; then
  apt-get install -y lsb-release ca-certificates curl gnupg2 apt-transport-https >/dev/null
  curl -fsSL https://packages.sury.org/php/apt.gpg -o /etc/apt/trusted.gpg.d/sury-php.gpg
  echo "deb https://packages.sury.org/php/ bookworm main" > /etc/apt/sources.list.d/sury-php.list
  apt-get update >/dev/null
  apt-get install -y php8.4-cli php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip \
    php8.4-sqlite3 php8.4-mysql php8.4-bcmath php8.4-gd php8.4-intl php8.4-common unzip >/dev/null
  ln -sf /usr/bin/php8.4 /usr/local/bin/php
fi
if ! command -v composer >/dev/null 2>&1; then
  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
fi

echo "==> Installing dependencies & building assets"
[ -d vendor ] || composer install --no-interaction --prefer-dist
[ -f database/database.sqlite ] || touch database/database.sqlite
grep -q '^APP_KEY=base64' .env || php artisan key:generate --force
php artisan storage:link 2>/dev/null || true
php artisan migrate --force --seed
[ -d node_modules ] || npm install --ignore-scripts
npm run build

echo "==> Configuring supervisor (Laravel on port 3000)"
cat > /etc/supervisor/conf.d/laravel.conf <<'CONF'
[program:laravel]
command=/usr/local/bin/php artisan serve --host 0.0.0.0 --port 3000
directory=/app
autostart=true
autorestart=true
stderr_logfile=/var/log/supervisor/laravel.err.log
stdout_logfile=/var/log/supervisor/laravel.out.log
stopsignal=TERM
stopasgroup=true
killasgroup=true
CONF

supervisorctl stop backend frontend 2>/dev/null || true
supervisorctl reread
supervisorctl update
supervisorctl restart laravel 2>/dev/null || true
echo "==> Done. App should be live on port 3000."

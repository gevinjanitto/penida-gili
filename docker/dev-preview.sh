#!/bin/bash
# Restores the Emergent preview of the Laravel app after a pod restart:
# installs PHP 8.4 + MariaDB if missing, seeds MySQL, builds assets and serves on :3000.
set -e
cd /app/penida-gili

if ! command -v php >/dev/null 2>&1; then
    apt-get update -qq && apt-get install -y -qq lsb-release ca-certificates curl gnupg >/dev/null
    curl -sSLo /tmp/sury.deb https://packages.sury.org/debsuryorg-archive-keyring.deb && dpkg -i /tmp/sury.deb >/dev/null
    echo "deb [signed-by=/usr/share/keyrings/deb.sury.org-php.gpg] https://packages.sury.org/php/ bookworm main" > /etc/apt/sources.list.d/php.list
    apt-get update -qq && apt-get install -y -qq php8.4-cli php8.4-mysql php8.4-sqlite3 php8.4-mbstring php8.4-xml php8.4-curl php8.4-zip php8.4-gd php8.4-intl php8.4-bcmath unzip >/dev/null
fi
command -v composer >/dev/null 2>&1 || (curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer >/dev/null)
command -v mysqld >/dev/null 2>&1 || DEBIAN_FRONTEND=noninteractive apt-get install -y -qq mariadb-server >/dev/null

mkdir -p /run/mysqld && chown mysql:mysql /run/mysqld
pgrep -x mariadbd >/dev/null || pgrep -x mysqld >/dev/null || (nohup mysqld_safe >/tmp/mysqld.log 2>&1 &)
sleep 6
mysql -uroot -e "CREATE DATABASE IF NOT EXISTS penida; CREATE USER IF NOT EXISTS 'penida'@'localhost' IDENTIFIED BY 'penida'; GRANT ALL ON penida.* TO 'penida'@'localhost'; FLUSH PRIVILEGES;"

[ -d vendor ] || composer install --no-interaction -q
[ -d node_modules ] || npm ci --silent
npm run build >/dev/null
php artisan migrate --force && php artisan app:seed-if-empty && php artisan storage:link --force >/dev/null 2>&1 || true

sudo supervisorctl stop frontend >/dev/null 2>&1 || true
pkill -f "artisan serve" || true
PHP_CLI_SERVER_WORKERS=6 nohup php artisan serve --host 0.0.0.0 --port 3000 > /tmp/laravel.log 2>&1 &
echo "Preview running on :3000"

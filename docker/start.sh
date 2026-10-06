#!/bin/sh
# Container entrypoint for Railway: wait for MySQL, migrate, seed on first boot, then serve.
set -e
cd /app

if [ -z "$APP_KEY" ]; then
    # Don't crash-loop the deploy: boot with a temporary key, but warn loudly.
    # Sessions/logins reset on every redeploy until APP_KEY is set in Railway Variables.
    APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    export APP_KEY
    echo "[penida] WARNING: APP_KEY is not set — using a temporary key. Set APP_KEY in Railway Variables (php artisan key:generate --show)." >&2
fi

echo "[penida] Waiting for the database..."
tries=0
until php artisan tinker --execute="DB::connection()->getPdo();" >/dev/null 2>&1 || [ "$tries" -ge 30 ]; do
    tries=$((tries + 1))
    sleep 2
done

php artisan storage:link --force >/dev/null 2>&1 || true

# Data-loss guards: these are the two usual reasons content "disappears" after a redeploy.
DB_DRIVER=$(php artisan tinker --execute="echo config('database.default');" 2>/dev/null | tail -n 1)
if [ "$DB_DRIVER" = "sqlite" ]; then
    echo "[penida] WARNING: no MySQL configured — using SQLite inside the container. ALL DATA IS WIPED ON EVERY REDEPLOY." >&2
    echo "[penida]          Add a MySQL database in Railway and set DB_URL=\${{MySQL.MYSQL_URL}} on this service." >&2
fi
if ! grep -q " /app/storage/app/public " /proc/mounts 2>/dev/null; then
    echo "[penida] WARNING: no Railway Volume at /app/storage/app/public — photos uploaded in the admin are lost on every redeploy." >&2
fi

php artisan migrate --force
php artisan app:seed-if-empty
php artisan app:repair-schedules || true
php artisan app:catalogue-status || true
php artisan optimize || true

echo "[penida] Serving on port ${PORT:-8080}"
exec frankenphp php-server --root /app/public --listen "0.0.0.0:${PORT:-8080}"

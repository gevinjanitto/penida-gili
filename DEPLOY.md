# Deploying Penida Gili to Railway (Laravel 13 + MySQL)

1. **Push this repo to GitHub**, then in Railway: *New Project → Deploy from GitHub repo*.
   Railway picks up `railway.json` and builds the `Dockerfile` (FrankenPHP, PHP 8.4).
   The repository root now contains its own `Dockerfile` + `railway.json` + `.dockerignore` that build the
   `penida-gili/` sub-folder, so **leave Root Directory empty** (fixes "Railpack could not determine how to
   build the app"). Alternatively set *Root Directory* to `/penida-gili` — both work.
2. **Add MySQL**: *New → Database → MySQL* in the same project.
3. **Variables** on the web service (Settings → Variables):

   | Variable | Value |
   | --- | --- |
   | `APP_KEY` | output of `php artisan key:generate --show` (e.g. `base64:...`) |
   | `APP_URL` | `https://<your-app>.up.railway.app` (or your custom domain) |
   | `DB_CONNECTION` | `mysql` |
   | `DB_URL` | `${{MySQL.MYSQL_URL}}` |
   | `ADMIN_EMAIL` / `ADMIN_PASSWORD` | the first admin login (seeded on first boot) |
   | `BOOKING_WHATSAPP` / `BOOKING_EMAIL` | where bookings are sent |
   | `SESSION_DRIVER`, `CACHE_STORE`, `QUEUE_CONNECTION` | `database` (defaults) |

   `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE` are also read automatically
   if you prefer referencing them instead of `DB_URL`.
4. **Uploads**: attach a *Volume* to the web service mounted at `/app/storage/app/public`
   so photos uploaded in the admin console survive redeploys.
5. **Networking → Generate Domain.** The container listens on Railway's `$PORT`; the health check is `/up`.

On every boot `docker/start.sh` waits for MySQL, runs `migrate --force`, seeds the catalogue and the admin
account **only when the database is empty** (`php artisan app:seed-if-empty`), links storage and caches config.

Admin console: `/admin` (also linked from the footer next to the MaiHarta credit).

## Local development

```bash
cp .env.example .env && php artisan key:generate
# set DB_CONNECTION=mysql and DB_* for your local MySQL
composer install && npm ci
php artisan migrate --seed
npm run build   # or: composer run dev
php artisan serve
```

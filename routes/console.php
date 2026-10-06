<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Used by the container start script: seed the catalogue and the admin account
 * only on the very first boot, so later deploys never overwrite console edits.
 */
Artisan::command('app:seed-if-empty', function () {
    if (\App\Models\User::query()->exists()) {
        $this->info('Database already seeded — skipping.');

        return;
    }

    $this->call('db:seed', ['--force' => true]);
})->purpose('Seed the database on first deploy only');

/*
 * Run on every boot (after migrate). Databases migrated from an older version can hold
 * schedules whose route_id is NULL (the port columns were dropped before being copied
 * into routes) or whose route/port was deleted. Those rows used to 500 the home page.
 * - broken active schedules are moved to Draft so the admin can re-assign a route;
 * - if no bookable sailing is left at all, the default ports + fleet schedules are restored.
 */
Artisan::command('app:repair-schedules', function () {
    $broken = \App\Models\Schedule::query()
        ->where('status', \App\Enums\ListingStatus::Active)
        ->whereDoesntHave('route', fn ($r) => $r->whereHas('originPort')->whereHas('destinationPort'))
        ->pluck('id');

    if ($broken->isNotEmpty()) {
        \App\Models\Schedule::query()->whereKey($broken)->update(['status' => \App\Enums\ListingStatus::Draft->value]);
        $this->warn('Moved '.$broken->count().' schedule(s) without a valid route to Draft: #'.$broken->join(', #'));
    }

    if (\App\Models\Schedule::query()->active()->doesntExist()) {
        $this->warn('No bookable schedule left — restoring default ports and fleet schedules.');
        $this->call('db:seed', ['--class' => \Database\Seeders\PortSeeder::class, '--force' => true]);
        $this->call('db:seed', ['--class' => \Database\Seeders\BoatOperatorSeeder::class, '--force' => true]);
    }

    $this->info('Schedules OK ('.\App\Models\Schedule::query()->active()->count().' bookable).');
})->purpose('Repair schedules left without a valid route by older migrations');

/*
 * Brings a database created by an older version of the app up to the current catalogue:
 * missing destinations, ports, boats, sailings, hotels, activities, articles, galleries
 * and reviews are added; existing rows only get their *blank* fields filled
 * (see Database\Seeders\Support\Seed::fill), so console edits are never overwritten.
 * Runs once automatically through the 2026_10_06 migration; safe to run again by hand.
 */
Artisan::command('app:sync-catalogue', function () {
    $seeders = [
        \Database\Seeders\PortSeeder::class,
        \Database\Seeders\BoatOperatorSeeder::class,
        \Database\Seeders\HotelSeeder::class,
        \Database\Seeders\ActivitySeeder::class,
        \Database\Seeders\ArticleSeeder::class,
        \Database\Seeders\ArticleContentSeeder::class,
        \Database\Seeders\LocationSeeder::class,
    ];

    foreach ($seeders as $seeder) {
        try {
            $this->callSilently('db:seed', ['--class' => $seeder, '--force' => true]);
            $this->line('  synced '.class_basename($seeder));
        } catch (\Throwable $e) {
            report($e);
            $this->error('  '.class_basename($seeder).' failed: '.$e->getMessage());
        }
    }

    $this->call('app:catalogue-status');
})->purpose('Add catalogue content missing from databases created by older versions');

Artisan::command('app:catalogue-status', function () {
    $counts = collect([
        'locations' => \App\Models\Location::class,
        'ports' => \App\Models\Port::class,
        'operators' => \App\Models\BoatOperator::class,
        'vessels' => \App\Models\Vessel::class,
        'schedules' => \App\Models\Schedule::class,
        'hotels' => \App\Models\Hotel::class,
        'activities' => \App\Models\Activity::class,
        'articles' => \App\Models\Article::class,
        'bookings' => \App\Models\Booking::class,
    ])->map(fn (string $model) => rescue(fn () => $model::query()->count(), '?', false));

    $this->info('[penida] DB '.config('database.default').' — '.$counts->map(fn ($n, $k) => "$k=$n")->join(' '));
})->purpose('Print how many catalogue rows the database holds');

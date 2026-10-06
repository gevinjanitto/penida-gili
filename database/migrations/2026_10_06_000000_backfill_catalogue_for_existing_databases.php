<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/**
 * One-time data upgrade for databases seeded by an older version of the app.
 *
 * `app:seed-if-empty` skips seeding as soon as an admin user exists, so destinations,
 * galleries, reviews, article content and new sailings added in later versions never
 * reached those databases. This migration runs exactly once per database and fills in
 * only what is missing. Fresh databases are skipped here — they are fully seeded by
 * `app:seed-if-empty` right after `migrate`.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || ! User::query()->exists()) {
            return;
        }

        Artisan::call('app:sync-catalogue');
    }

    public function down(): void
    {
        // Data backfill only — nothing to roll back.
    }
};

<?php

use App\Models\User;
use Database\Seeders\CatalogueContentSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

/**
 * One-time content upgrade (v2): longer hotel / activity / article pages, photos that
 * match each title, hotel highlights, policies and nearby places. Runs once per database;
 * fresh databases get the same content from DatabaseSeeder via app:seed-if-empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || ! User::query()->exists()) {
            return;
        }

        Artisan::call('db:seed', ['--class' => CatalogueContentSeeder::class, '--force' => true]);
    }

    public function down(): void
    {
        // Content update only.
    }
};

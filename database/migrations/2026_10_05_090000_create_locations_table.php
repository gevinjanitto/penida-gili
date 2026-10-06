<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Master list of destinations (Nusa Penida, Nusa Lembongan, Gili Trawangan,
 * Bali …). Ports and activities hang off a location so the "Where To?" search
 * and the boat search share one source of truth managed in the console.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable()->comment('Relative to public/images/locations or an uploads/ path');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });

        Schema::table('ports', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('area')->constrained()->nullOnDelete();
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('location_id')->nullable()->after('location')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::table('ports', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::dropIfExists('locations');
    }
};

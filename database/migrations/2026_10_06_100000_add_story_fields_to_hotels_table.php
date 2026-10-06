<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Longer hotel pages: "Why Guests Love It" highlights, "Good to Know" policies and
 * "What's Nearby" — all edited in the console's hotel form.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->json('highlights')->nullable()->after('amenities');
            $table->json('policies')->nullable()->after('highlights');
            $table->json('nearby')->nullable()->after('policies');
        });
    }

    public function down(): void
    {
        Schema::table('hotels', function (Blueprint $table) {
            $table->dropColumn(['highlights', 'policies', 'nearby']);
        });
    }
};

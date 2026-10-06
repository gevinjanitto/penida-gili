<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Foreign (non-Indonesian) child fare, so every sailing carries four prices:
 * domestic adult / child (price_adult, price_child) and foreign adult / child
 * (price_foreign, price_child_foreign). Existing rows are backfilled with the
 * figure the schedule list already showed (foreign adult × the domestic child ratio).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedInteger('price_child_foreign')->nullable()->after('price_foreign');
        });

        DB::table('schedules')->whereNull('price_foreign')->update(['price_foreign' => DB::raw('price_adult')]);

        DB::table('schedules')->orderBy('id')->each(function ($row) {
            $ratio = $row->price_adult > 0 ? $row->price_child / $row->price_adult : 0.75;

            DB::table('schedules')->where('id', $row->id)->update([
                'price_child_foreign' => (int) round($row->price_foreign * $ratio),
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn('price_child_foreign');
        });
    }
};

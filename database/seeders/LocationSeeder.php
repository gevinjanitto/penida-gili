<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Location;
use App\Models\Port;
use Database\Seeders\Support\Seed;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Nusa Penida', 'tagline' => 'Cliffs, mantas & Kelingking Beach', 'description' => 'Dramatic limestone cliffs, crystal bays and the famous T-Rex shaped Kelingking Beach — the wild sister island of Bali.', 'image' => 'nusa-penida.jpg', 'sort_order' => 1],
            ['name' => 'Nusa Lembongan', 'tagline' => 'Mangroves, reefs & sunset bars', 'description' => 'A laid-back island of seaweed farms, mangrove forests, Devil\'s Tear and turquoise snorkeling spots.', 'image' => 'nusa-lembongan.jpg', 'sort_order' => 2],
            ['name' => 'Gili Trawangan', 'tagline' => 'Turtles, bikes & white sand', 'description' => 'No cars, just bicycles and horse carts — snorkel with sea turtles and watch the sunset on the famous swings.', 'image' => 'gili-trawangan.jpg', 'sort_order' => 3],
            ['name' => 'Bali', 'tagline' => 'Temples, culture & rice terraces', 'description' => 'The Island of the Gods: ancient temples, cultural dances, rice terraces and world-class beaches.', 'image' => 'bali.jpg', 'sort_order' => 4],
        ];

        foreach ($locations as $data) {
            Seed::fill(Location::query(), ['name' => $data['name']], $data + ['is_active' => true]);
        }

        $ids = Location::query()->pluck('id', 'name');

        // Ports follow the island they sit on.
        $portLocations = [
            'Sanur' => 'Bali', 'Kusamba' => 'Bali', 'Padang Bai' => 'Bali',
            'Nusa Penida' => 'Nusa Penida', 'Nusa Lembongan' => 'Nusa Lembongan',
            'Gili Trawangan' => 'Gili Trawangan', 'Gili Air' => 'Gili Trawangan',
        ];

        foreach ($portLocations as $port => $location) {
            Port::query()->where('name', $port)->whereNull('location_id')->update(['location_id' => $ids[$location] ?? null]);
        }

        // Activities: anything mentioning one of the islands goes there, the rest is mainland Bali.
        Activity::query()->whereNull('location_id')->get()->each(function (Activity $activity) use ($ids): void {
            $haystack = $activity->name.' '.$activity->location.' '.$activity->place_label;
            $match = collect(['Nusa Penida', 'Nusa Lembongan', 'Gili Trawangan'])
                ->first(fn (string $name) => str_contains($haystack, $name) || str_contains($haystack, str_replace('Nusa ', '', $name)));

            $activity->update(['location_id' => $ids[$match ?? 'Bali']]);
        });
    }
}

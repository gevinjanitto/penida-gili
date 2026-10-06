<?php

namespace Database\Seeders;

use App\Enums\ListingStatus;
use App\Models\BoatOperator;
use App\Models\Port;
use App\Models\Route;
use Database\Seeders\Support\Seed;
use Illuminate\Database\Seeder;

class BoatOperatorSeeder extends Seeder
{
    public function run(): void
    {
        $ports = Port::query()->pluck('id', 'name');

        $facilities = [
            ['icon' => 'air-conditioning.svg', 'label' => 'Air Conditioning'],
            ['icon' => 'toilet.svg', 'label' => 'Toilet'],
            ['icon' => 'life-jackets.svg', 'label' => 'Life Jackets'],
            ['icon' => 'insurance.svg', 'label' => 'Insurance'],
        ];

        $galleries = [
            'Maruti Fast Boat' => [
                ['image' => 'maruti-side.png', 'alt' => 'Side view'],
                ['image' => 'maruti-front.png', 'alt' => 'Front view'],
                ['image' => 'maruti-deck.png', 'alt' => 'Deck view'],
                ['image' => 'deck-seats.jpg', 'alt' => 'Passenger cabin seating'],
                ['image' => 'wake-blue.jpg', 'alt' => 'Cruising the Badung Strait'],
            ],
            'Semabu Hill Fast Boat' => [
                ['image' => 'fleet-sea.jpg', 'alt' => 'Fast boat at sea'],
                ['image' => 'island-hop.jpg', 'alt' => 'Island hopping crossing'],
                ['image' => 'deck-sunset.jpg', 'alt' => 'Sunset from the upper deck'],
                ['image' => 'aerial-wake.jpg', 'alt' => 'Aerial view of the wake'],
            ],
            'Angel Billabong Fast Cruise' => [
                ['image' => 'cruise-side.jpg', 'alt' => 'Side profile at speed'],
                ['image' => 'sunset-ride.jpg', 'alt' => 'Golden hour crossing'],
                ['image' => 'deck-seats.jpg', 'alt' => 'Comfortable cabin seats'],
                ['image' => 'wake-blue.jpg', 'alt' => 'Open water cruising'],
            ],
        ];

        $operators = [
            [
                'name' => 'Maruti Fast Boat',
                'description' => 'Daily fast boat crossings from Sanur to Nusa Penida, Nusa Lembongan and the Gili Islands with friendly crew and free hotel pick-up in south Bali.',
                'tagline' => 'Reliable daily crossings from Sanur with free south Bali pick-up.',
                'rating' => 4.8, 'review_count' => 124, 'image' => 'boat-maruti.png',
                'top_speed_knots' => 35, 'capacity' => 100,
                'vessels' => [
                    ['name' => 'Sanjaya Ocean Queen', 'code' => 'SFB-001', 'type' => 'Catamaran Fast Ferry', 'capacity' => 150, 'top_speed_knots' => 24, 'engine' => '4 x 250 HP Yamaha', 'description' => 'Our flagship catamaran: a wide, stable hull, air-conditioned cabin and open upper deck for the 45-minute crossing to Nusa Penida.', 'inspected_at' => '2023-10-12'],
                    ['name' => 'Sanjaya Express II', 'code' => 'SFB-002', 'type' => 'Mono-hull Fastboat', 'capacity' => 85, 'top_speed_knots' => 28, 'engine' => '3 x 250 HP Suzuki', 'description' => 'A nimble mono-hull for the afternoon return sailings, with cushioned seats, luggage racks and an onboard toilet.', 'inspected_at' => '2023-11-01'],
                ],
                'routes' => [
                    ['Sanur', 'Nusa Penida', '08:00', '08:45', 100_000],
                    ['Nusa Penida', 'Sanur', '16:00', '16:45', 100_000],
                    ['Sanur', 'Gili Trawangan', '09:00', '11:30', 350_000],
                    ['Sanur', 'Nusa Lembongan', '08:30', '09:00', 150_000],
                    ['Nusa Lembongan', 'Sanur', '15:30', '16:00', 150_000],
                    ['Sanur', 'Nusa Penida', '13:00', '13:45', 100_000],
                ],
            ],
            [
                'name' => 'Semabu Hill Fast Boat',
                'description' => 'Nusa Penida based operator with comfortable mono-hull boats, punctual departures and island-hopping links between Penida and Lembongan.',
                'tagline' => 'Locally owned, punctual and perfect for island hopping.',
                'rating' => 4.7, 'review_count' => 98, 'image' => 'boat-semabu.png',
                'top_speed_knots' => 30, 'capacity' => 80,
                'vessels' => [
                    ['name' => 'Sanjaya Explorer', 'code' => 'SFB-005', 'type' => 'Luxury Catamaran', 'capacity' => 120, 'top_speed_knots' => 30, 'engine' => '4 x 300 HP Mercury', 'description' => 'Luxury catamaran with reclining seats, panoramic windows and a sun deck — ideal for families and groups.', 'inspected_at' => '2023-09-28'],
                    ['name' => 'Semabu Voyager', 'code' => 'SFB-006', 'type' => 'Mono-hull Fastboat', 'capacity' => 80, 'top_speed_knots' => 28, 'engine' => '3 x 200 HP Yamaha', 'description' => 'Semabu Voyager links Nusa Penida, Lembongan and Sanur several times a day with a friendly local crew.', 'inspected_at' => '2024-01-15'],
                ],
                'routes' => [
                    ['Sanur', 'Nusa Penida', '09:30', '10:15', 100_000],
                    ['Nusa Penida', 'Sanur', '15:00', '15:45', 100_000],
                    ['Sanur', 'Nusa Lembongan', '10:00', '10:30', 150_000],
                    ['Nusa Penida', 'Nusa Lembongan', '11:00', '11:15', 75_000],
                    ['Nusa Lembongan', 'Nusa Penida', '16:30', '16:45', 75_000],
                ],
            ],
            [
                'name' => 'Angel Billabong Fast Cruise',
                'description' => 'Premium catamaran service from Kusamba and Padang Bai — the shortest crossing to Nusa Penida and a smooth ride to Gili Trawangan.',
                'tagline' => 'The shortest crossing to Nusa Penida on a stable catamaran.',
                'rating' => 4.9, 'review_count' => 210, 'image' => 'boat-angel.png',
                'top_speed_knots' => 32, 'capacity' => 120,
                'vessels' => [
                    ['name' => 'Angel Billabong I', 'code' => 'SFB-010', 'type' => 'Catamaran Fast Ferry', 'capacity' => 120, 'top_speed_knots' => 32, 'engine' => '4 x 300 HP Yamaha', 'description' => 'Angel Billabong I makes the short Kusamba hop to Penida and the longer Padang Bai to Gili Trawangan run in comfort.', 'inspected_at' => '2024-02-20'],
                ],
                'routes' => [
                    ['Kusamba', 'Nusa Penida', '07:30', '08:00', 90_000],
                    ['Nusa Penida', 'Kusamba', '14:30', '15:00', 90_000],
                    ['Padang Bai', 'Gili Trawangan', '09:00', '10:30', 400_000],
                    ['Gili Trawangan', 'Padang Bai', '13:00', '14:30', 400_000],
                    ['Kusamba', 'Nusa Penida', '17:00', '17:30', 90_000],
                ],
            ],
        ];

        foreach ($operators as $data) {
            $vessels = $data['vessels'];
            $routes = $data['routes'];
            unset($data['vessels'], $data['routes']);

            $operator = Seed::fill(BoatOperator::query(), 
                ['name' => $data['name']],
                $data + ['hero_image' => $data['image'], 'facilities' => $facilities, 'gallery' => $galleries[$data['name']] ?? []],
            );

            $vesselIds = [];
            foreach ($vessels as $vessel) {
                // Each vessel is its own listing, so it carries the operator's photo,
                // copy and rating until the console replaces them.
                $vessel += [
                    'description' => $data['description'],
                    'rating' => $data['rating'],
                    'image' => $data['image'],
                    'facilities' => array_column($facilities, 'label'),
                    'gallery' => collect($galleries[$data['name']] ?? [])
                        ->map(fn (array $photo) => ['image' => 'gallery/'.$photo['image'], 'alt' => $photo['alt']])
                        ->all(),
                ];
                $vesselIds[] = Seed::fill($operator->vessels(), ['code' => $vessel['code']], $vessel)->id;
            }

            foreach ($routes as $i => [$from, $to, $depart, $arrive, $price]) {
                $route = Route::query()->firstOrCreate(
                    ['origin_port_id' => $ports[$from], 'destination_port_id' => $ports[$to]],
                    ['name' => $from.' - '.$to, 'is_active' => true],
                );

                Seed::fill($operator->schedules(), 
                    ['route_id' => $route->id, 'departure_time' => $depart],
                    [
                        'vessel_id' => $vesselIds[$i % count($vesselIds)],
                        'arrival_time' => $arrive,
                        'price_adult' => $price,
                        'price_child' => (int) round($price * 0.75),
                        'price_foreign' => (int) round($price * 1.8),
                        'price_child_foreign' => (int) round($price * 1.8 * 0.75),
                        'days' => null,
                        'status' => ListingStatus::Active,
                    ],
                );
            }

            // Every boat gets its own guest testimonials (shown on the boat page and the home page).
            $vesselQuotes = [
                ['name' => 'Sarah Jenkins', 'stars' => 5, 'quote' => 'Incredibly smooth ride and the crew was extremely helpful with our luggage. Highly recommend for trips to Nusa Penida!', 'experienced_at' => '2026-08-14'],
                ['name' => 'Mark D.', 'stars' => 5, 'quote' => 'Fast and comfortable. The AC worked perfectly which was a lifesaver in the heat. Will book again.', 'experienced_at' => '2026-07-22'],
                ['name' => 'Ayu Pratiwi', 'stars' => 5, 'quote' => 'Departed right on time, clean seats and a stunning view from the upper deck. Booking took two minutes.', 'experienced_at' => '2026-09-03'],
                ['name' => 'Lukas Weber', 'stars' => 4, 'quote' => 'Great value for the crossing, staff loaded our surfboards carefully and the ride was calmer than expected.', 'experienced_at' => '2026-06-18'],
            ];
            foreach ($operator->vessels()->get() as $v => $boat) {
                if ($boat->reviews()->doesntExist()) {
                    $boat->reviews()->createMany(collect($vesselQuotes)->slice($v % 2, 3)->map(fn ($q) => $q + ['is_published' => true])->values()->all());
                }
            }

            if ($operator->reviews()->doesntExist()) {
                $operator->reviews()->createMany([
                    ['name' => 'Sarah Jenkins', 'stars' => 5, 'quote' => '"Incredibly smooth ride and the staff was extremely helpful with our luggage. Highly recommend for trips to Nusa Penida!"', 'experienced_at' => '2023-10-15'],
                    ['name' => 'Mark D.', 'stars' => 4, 'quote' => '"Fast and comfortable. The AC worked perfectly which was a lifesaver in the heat. Will book again."', 'experienced_at' => '2023-09-20'],
                ]);
            }
        }
    }
}

<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Route> */
class RouteFactory extends Factory
{
    protected $model = Route::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'origin_port_id' => Port::factory(),
            'destination_port_id' => Port::factory(),
            'is_active' => true,
        ];
    }
}

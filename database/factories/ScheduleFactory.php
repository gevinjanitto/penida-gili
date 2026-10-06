<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Models\BoatOperator;
use App\Models\Port;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Schedule> */
class ScheduleFactory extends Factory
{
    public function definition(): array
    {
        $hour = fake()->numberBetween(7, 16);

        return [
            'boat_operator_id' => BoatOperator::factory(),
            'vessel_id' => null,
            'route_id' => \App\Models\Route::factory(),
            'departure_time' => sprintf('%02d:00', $hour),
            'arrival_time' => sprintf('%02d:45', $hour),
            'price_adult' => 180_000,
            'price_child' => 135_000,
            'price_foreign' => null,
            'days' => null,
            'status' => ListingStatus::Active,
        ];
    }

    public function draft(): static
    {
        return $this->state(['status' => ListingStatus::Draft]);
    }

    /**
     * Older tests still describe a sailing by its two ports; translate those into
     * the route the schedules table now references.
     */
    public function newModel(array $attributes = [])
    {
        if (isset($attributes['from_port_id'], $attributes['to_port_id'])) {
            $attributes['route_id'] = \App\Models\Route::query()->firstOrCreate(
                ['origin_port_id' => $attributes['from_port_id'], 'destination_port_id' => $attributes['to_port_id']],
                ['name' => 'Route '.$attributes['from_port_id'].'-'.$attributes['to_port_id'], 'is_active' => true],
            )->id;
        }

        unset($attributes['from_port_id'], $attributes['to_port_id']);

        return parent::newModel($attributes);
    }
}

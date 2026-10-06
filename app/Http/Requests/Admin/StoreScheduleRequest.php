<?php

namespace App\Http\Requests\Admin;

use App\Enums\ListingStatus;
use App\Models\Port;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Vessel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreScheduleRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $merge = [];

        if ($this->filled('route')) {
            $routeId = (int) $this->input('route');

            if ($routeId > 0) {
                $merge['route_id'] = $routeId;
            }
        }

        // No established route picked: build one from the two ports chosen in the console.
        if (! isset($merge['route_id']) && $this->filled('new_origin_port_id') && $this->filled('new_destination_port_id')
            && (int) $this->input('new_origin_port_id') !== (int) $this->input('new_destination_port_id')) {
            $origin = Port::query()->find($this->integer('new_origin_port_id'));
            $destination = Port::query()->find($this->integer('new_destination_port_id'));

            if ($origin && $destination) {
                $merge['route_id'] = Route::query()->firstOrCreate(
                    ['origin_port_id' => $origin->id, 'destination_port_id' => $destination->id],
                    ['name' => $origin->name.' - '.$destination->name, 'is_active' => true],
                )->id;
                $merge['route'] = $merge['route_id'];
            }
        }

        if ($this->filled('vessel_id') && ! $this->filled('boat_operator_id')) {
            $merge['boat_operator_id'] = Vessel::query()
                ->whereKey($this->integer('vessel_id'))
                ->value('boat_operator_id');
        }

        if ($this->filled('publish')) {
            $merge['status'] = $this->input('publish') === 'draft'
                ? ListingStatus::Draft->value
                : ListingStatus::Active->value;
        }

        $this->merge($merge);
    }

    public function rules(): array
    {
        return [
            'route' => ['required_without:new_origin_port_id', 'nullable', 'integer', Rule::exists('routes', 'id')],
            'new_origin_port_id' => ['nullable', 'integer', Rule::exists('ports', 'id'), 'different:new_destination_port_id'],
            'new_destination_port_id' => ['nullable', 'required_with:new_origin_port_id', 'integer', Rule::exists('ports', 'id')],
            'route_id' => ['required', Rule::exists('routes', 'id')],

            'publish' => ['nullable', Rule::in(['publish', 'draft'])],

            'boat_operator_id' => [
                'required',
                Rule::exists('boat_operators', 'id'),
            ],

            'vessel_id' => [
                'required',
                Rule::exists('vessels', 'id')
                    ->where('boat_operator_id', $this->integer('boat_operator_id')),
            ],

            'departure_time' => ['required', 'date_format:H:i'],

            'arrival_time' => [
                'required',
                'date_format:H:i',
                'after:departure_time',
            ],

            'price_adult' => ['required', 'integer', 'min:0'],
            'price_child' => ['required', 'integer', 'min:0'],
            'price_foreign' => ['nullable', 'integer', 'min:0'],
            'price_child_foreign' => ['nullable', 'integer', 'min:0'],

            'days' => ['nullable', 'array'],
            'days.*' => [Rule::in(Schedule::DAYS)],

            'status' => [
                'required',
                Rule::enum(ListingStatus::class),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'route_id.required' => 'Choose a route.',
            'route_id.exists' => 'The selected route does not exist.',
            'arrival_time.after' => 'Arrival must be later than departure.',
        ];
    }

    /**
     * Validated attributes ready for the Schedule model.
     *
     * @return array<string, mixed>
     */
    public function payload(): array
    {
        $data = collect($this->validated())
            ->except(['route', 'publish', 'new_origin_port_id', 'new_destination_port_id'])
            ->all();

        $days = array_values(array_unique($data['days'] ?? []));

        $data['days'] = (
            $days === []
            || count($days) === count(Schedule::DAYS)
        ) ? null : $days;

        $data['price_foreign'] = $data['price_foreign'] ?? null;
        $data['price_child_foreign'] = $data['price_child_foreign'] ?? null;

        return $data;
    }
}
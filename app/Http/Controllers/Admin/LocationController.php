<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Port;
use App\Support\Uploads;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Master Locations — the destinations used by the "Where To?" search, the
 * activity catalogue and the grouping of ports in the boat search.
 */
class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = Location::query()
            ->withCount([
                'ports',
                'activities',
                'activities as active_activities_count' => fn ($q) => $q->where('status', ListingStatus::Active),
            ])
            ->with('ports')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%'.$request->string('q').'%'))
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.locations', [
            'locations' => $locations,
            'filters' => $request->only('q'),
            'activeCount' => Location::query()->active()->count(),
            'totalCount' => Location::query()->count(),
            'unassignedPorts' => Port::query()->whereNull('location_id')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return $this->form(new Location(['is_active' => true, 'sort_order' => Location::query()->max('sort_order') + 1]));
    }

    public function store(Request $request): RedirectResponse
    {
        $location = Location::query()->create($this->payload($request));
        $this->syncPorts($request, $location);

        return redirect()->route('admin.locations')->with('flash', "{$location->name} added.");
    }

    public function edit(Location $location): View
    {
        return $this->form($location->load('ports'));
    }

    public function update(Request $request, Location $location): RedirectResponse
    {
        $location->update($this->payload($request, $location));
        $this->syncPorts($request, $location);

        return redirect()->route('admin.locations')->with('flash', "{$location->name} updated.");
    }

    public function destroy(Location $location): RedirectResponse
    {
        // Ports and activities keep existing; they simply lose the destination link (nullOnDelete).
        $location->delete();

        return redirect()->route('admin.locations')->with('flash', "{$location->name} removed.");
    }

    private function form(Location $location): View
    {
        return view('admin.locations-create', [
            'location' => $location,
            'ports' => Port::query()->with('location')->orderBy('name')->get(),
        ]);
    }

    /** @return array<string, mixed> */
    private function payload(Request $request, ?Location $existing = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:160'],
            'description' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'cover' => ['nullable', 'image', 'max:5120'],
            'ports' => ['nullable', 'array'],
            'ports.*' => ['integer', 'exists:ports,id'],
            'new_ports' => ['nullable', 'string', 'max:500'],
        ]);

        $payload = [
            'name' => $data['name'],
            'tagline' => $data['tagline'] ?? null,
            'description' => $data['description'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'is_active' => $request->boolean('is_active'),
        ];

        if ($existing) {
            $payload['slug'] = $existing->slugFor($data['name']);
        }

        if ($cover = Uploads::store($request->file('cover'), 'locations')) {
            $payload['image'] = $cover;
        }

        return $payload;
    }

    /** Ticked ports belong to this location; new port names typed in are created here. */
    private function syncPorts(Request $request, Location $location): void
    {
        $ids = collect($request->input('ports', []))->map(fn ($id) => (int) $id);

        Port::query()->where('location_id', $location->id)->whereNotIn('id', $ids)->update(['location_id' => null]);
        Port::query()->whereIn('id', $ids)->update(['location_id' => $location->id]);

        collect(explode(',', (string) $request->input('new_ports')))
            ->map(fn ($name) => Str::of($name)->squish()->value())
            ->filter()
            ->unique()
            ->each(function (string $name) use ($location): void {
                $port = Port::query()->firstOrNew(['name' => $name]);
                $port->fill(['area' => $port->area ?: $location->name, 'location_id' => $location->id])->save();
            });
    }
}

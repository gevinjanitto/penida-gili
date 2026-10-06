{{-- Add / edit a master location. --}}
@extends('layouts.admin')

@section('title', $location->exists ? 'Edit Location' : 'Add New Location')

@section('admin-active', 'location')

@section('content')
    <x-admin.form-page
        :heading="$location->exists ? 'Edit Location' : 'Add New Location'"
        subtitle="Destinations appear in the “Where To?” search, group the ports in the boat search and filter the activity catalogue."
        :back-href="route('admin.locations')">

        <form action="{{ $location->exists ? route('admin.locations.update', $location) : route('admin.locations.store') }}" method="post" enctype="multipart/form-data"
              class="grid [&>*]:min-w-0 gap-[24px] xl:grid-cols-[minmax(0,1fr)_400px]">
            @csrf
            @if ($location->exists)
                @method('PUT')
            @endif

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Destination Details" description="Name, short tagline and the story shown on the destination page" icon="nav-activity.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.field label="Location Name" name="name" :value="$location->name" placeholder="Nusa Penida" :required="true" />
                        <x-admin.field label="Tagline" name="tagline" :value="$location->tagline" placeholder="Cliffs, mantas & Kelingking Beach" help="One short line shown under the name in the search dropdown and on cards." />
                        <x-admin.field label="Description" name="description" type="textarea" :value="$location->description" placeholder="Dramatic limestone cliffs, crystal bays…" />
                    </div>
                </x-admin.panel>

                <x-admin.panel title="Ports in this Location" description="Ports ticked here are grouped under this destination in the From / To dropdowns" icon="nav-schedule.svg" :badge="$location->ports->count().' linked'">
                    <div class="grid gap-[10px] sm:grid-cols-2">
                        @foreach ($ports as $port)
                            @php $checked = in_array($port->id, old('ports', $location->ports->pluck('id')->all())); @endphp
                            <label class="pg-check-card">
                                <input type="checkbox" name="ports[]" value="{{ $port->id }}" @checked($checked) class="peer sr-only">
                                <span class="pg-check-box"><x-ui-icon name="check" class="size-[12px]" stroke="3" /></span>
                                <span class="min-w-0 flex-1">
                                    <span class="block text-[14px] font-semibold text-editorial-ink">{{ $port->name }}</span>
                                    <span class="block text-[12px] text-editorial-meta">
                                        {{ $port->location && ! $port->location->is($location) ? 'Currently in '.$port->location->name : ($port->location ? 'Linked' : 'Unassigned') }}
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <div class="mt-[20px]">
                        <x-admin.field label="Add New Ports" name="new_ports" placeholder="Toya Pakeh, Banjar Nyuh" help="Comma separated. New ports are created and linked to this location." />
                    </div>
                </x-admin.panel>
            </div>

            <div class="flex flex-col gap-[24px]">
                <x-admin.panel title="Cover Photo" description="Used on the destination cards and page hero" icon="form-upload.svg">
                    <x-admin.uploader name="cover" :multiple="false" hint="PNG or JPG, landscape works best (max 5MB)">
                        @if ($location->image)
                            <img src="{{ $location->image_url }}" alt="" class="mt-[16px] h-[180px] w-full rounded-[12px] object-cover">
                        @endif
                    </x-admin.uploader>
                </x-admin.panel>

                <x-admin.panel title="Visibility" description="Control where and in which order it appears" icon="nav-dashboard.svg">
                    <div class="flex flex-col gap-[20px]">
                        <x-admin.toggle name="is_active" label="Active" description="Show in “Where To?”, home and footer" :checked="old('is_active', $location->is_active ?? true)" />
                        <x-admin.field label="Display Order" name="sort_order" type="number" min="0" max="999" :value="$location->sort_order" help="Lower numbers show first." />
                    </div>
                </x-admin.panel>

                <div class="flex gap-[12px]">
                    <a href="{{ route('admin.locations') }}" class="flex h-[48px] flex-1 items-center justify-center rounded-[10px] border border-[rgba(192,199,211,0.6)] text-[15px] font-semibold text-editorial-ink transition-colors hover:bg-[#f1f4f6]">Cancel</a>
                    <button type="submit" class="pg-shine flex h-[48px] flex-1 items-center justify-center gap-[8px] rounded-[10px] bg-editorial text-[15px] font-semibold text-white transition-transform duration-300 hover:-translate-y-0.5">
                        <x-ui-icon name="check" class="size-[16px]" /> {{ $location->exists ? 'Save Changes' : 'Create Location' }}
                    </button>
                </div>
            </div>
        </form>
    </x-admin.form-page>
@endsection

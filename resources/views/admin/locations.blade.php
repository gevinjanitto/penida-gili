{{-- Master Locations — destinations for "Where To?", activities and port grouping. --}}
@extends('layouts.admin')

@section('title', 'Locations')

@section('admin-active', 'location')

@section('content')
    <x-admin.listing
        heading="Locations"
        subtitle="Master destinations used by the “Where To?” search, the activity catalogue and the port groups in the boat search."
        action="Add New Location"
        :action-href="route('admin.locations.create')"
        :columns="['Destination', 'Ports', 'Activities', 'Order', 'Status', 'Actions']"
        :center-columns="['Activities', 'Order', 'Status']"
        :paginator="$locations"
        entity="locations"
        panel-title="Destination Master List"
        :panel-badge="$activeCount.' of '.$totalCount.' Active'">

        <x-slot:toolbar>
            <form action="{{ route('admin.locations') }}" method="get" class="flex flex-wrap items-center justify-between gap-[16px]">
                <label class="relative block w-[520px] max-w-full">
                    <span class="sr-only">Search</span>
                    <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search destinations..."
                           class="w-full rounded-[10px] border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] py-[10px] pl-[41px] pr-[13px] text-[14px] text-editorial-ink placeholder:text-editorial-meta focus:outline-2 focus:outline-editorial">
                    <x-ui-icon name="search" class="pointer-events-none absolute left-[13px] top-1/2 size-[17px] -translate-y-1/2 text-editorial-meta" />
                </label>
                @if ($unassignedPorts->isNotEmpty())
                    <p class="flex items-center gap-[8px] rounded-full bg-[#fff7ed] px-[14px] py-[6px] text-[13px] text-[#9a3412]">
                        <x-ui-icon name="anchor" class="size-[15px]" />
                        Ports without a location: <strong>{{ $unassignedPorts->pluck('name')->join(', ') }}</strong>
                    </p>
                @endif
            </form>
        </x-slot:toolbar>

        @forelse ($locations as $location)
            <tr class="pg-admin-row border-b border-[rgba(192,199,211,0.2)] last:border-b-0">
                <td class="px-[16px] py-[18px]">
                    <span class="flex items-center gap-[14px]">
                        <img src="{{ $location->image_url }}" alt="" class="h-[56px] w-[80px] shrink-0 rounded-[12px] object-cover shadow-[0_0_0_1px_rgba(192,199,211,0.4)]">
                        <span class="flex flex-col gap-[2px]">
                            <a href="{{ route('admin.locations.edit', $location) }}" class="text-[15px] font-bold leading-[20px] text-editorial-ink hover:text-editorial">{{ $location->name }}</a>
                            <span class="text-[12px] leading-[16px] text-editorial-body">{{ $location->tagline ?: '—' }}</span>
                            <a href="{{ route('activities.index', ['location' => $location->slug]) }}" target="_blank" class="inline-flex items-center gap-[4px] text-[11px] font-semibold text-editorial hover:underline">
                                View on site <x-ui-icon name="external" class="size-[11px]" />
                            </a>
                        </span>
                    </span>
                </td>
                <td class="px-[16px] py-[18px]">
                    <span class="flex max-w-[280px] flex-wrap gap-[6px]">
                        @forelse ($location->ports as $port)
                            <span class="inline-flex items-center gap-[4px] rounded-full bg-[#f1f4f6] px-[10px] py-[3px] text-[12px] text-editorial-body">
                                <x-ui-icon name="anchor" class="size-[11px]" /> {{ $port->name }}
                            </span>
                        @empty
                            <span class="text-[12px] text-editorial-meta">No ports</span>
                        @endforelse
                    </span>
                </td>
                <td class="px-[16px] py-[18px] text-center">
                    <span class="text-[15px] font-bold text-editorial-ink">{{ $location->active_activities_count }}</span>
                    <span class="text-[12px] text-editorial-meta">/ {{ $location->activities_count }}</span>
                </td>
                <td class="px-[16px] py-[18px] text-center text-[14px] text-editorial-body">#{{ $location->sort_order }}</td>
                <td class="px-[16px] py-[18px] text-center">
                    <span @class([
                        'inline-flex items-center gap-[6px] rounded-full px-[10px] py-[3px] text-[12px] font-semibold',
                        'bg-[#dcfce7] text-[#166534]' => $location->is_active,
                        'bg-[#f1f4f6] text-editorial-body' => ! $location->is_active,
                    ])>
                        <span @class(['size-[6px] rounded-full', 'bg-[#16a34a]' => $location->is_active, 'bg-[#94a3b8]' => ! $location->is_active])></span>
                        {{ $location->is_active ? 'Active' : 'Hidden' }}
                    </span>
                </td>
                <td class="px-[16px] py-[18px]">
                    <x-admin.row-actions :label="$location->name"
                                         :edit-href="route('admin.locations.edit', $location)"
                                         :delete-action="route('admin.locations.destroy', $location)" />
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-[16px] py-[48px] text-center text-[14px] text-editorial-body">No locations yet — add Nusa Penida, Nusa Lembongan, Gili Trawangan or Bali to get started.</td>
            </tr>
        @endforelse
    </x-admin.listing>
@endsection

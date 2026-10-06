{{-- Activities catalogue — also the landing page of the "Where To?" search (?location=slug). --}}
@extends('layouts.app')

@section('title', $currentLocation ? 'Things to do in '.$currentLocation->name : 'Activity')

@section('nav-active', 'activity')

@section('hero')
    @include('partials.hero-banner', [
        'image'    => $currentLocation?->image_url ?? asset('images/activities/hero-activity.png'),
        'active'   => 'activity',
        'eyebrow'  => $currentLocation ? 'Where To? · '.$currentLocation->tagline : 'Activities',
        'title'    => $currentLocation ? 'Things to do in <span class="text-sky-300">'.e($currentLocation->name).'</span>' : 'Activity',
        'subtitle' => $currentLocation?->description ?? 'A selection of exciting and unique activities to complete your unforgettable holiday experience.',
        'crumbs'   => array_filter(['Home' => route('home'), 'Activity' => $currentLocation ? route('activities.index') : null] + ($currentLocation ? [$currentLocation->name => null] : [])),
        'meta'     => $currentLocation ? [['compass', $activities->total().' '.str('activity')->plural($activities->total())]] : [],
    ])
@endsection

@section('content')
<section class="bg-[#f6f9fc] pb-[100px] lg:pb-[130px]">
    <div class="container-page">
        {{-- Destination switcher --}}
        <div data-reveal class="relative z-[35] -mt-[34px] lg:-mt-[60px]">
            <div class="flex gap-2 overflow-x-auto rounded-[22px] bg-white p-2 shadow-[0_20px_50px_-25px_rgba(6,30,56,0.35)] [scrollbar-width:none] lg:gap-3 lg:rounded-[30px] lg:p-3">
                <a href="{{ route('activities.index') }}"
                   @class(['pg-loc-tab', 'is-active' => ! $currentLocation])>
                    <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-sky-50 text-brand lg:size-14 lg:rounded-2xl"><x-ui-icon name="layers" class="size-4 lg:size-6" /></span>
                    <span class="text-left">
                        <span class="block font-semibold">All</span>
                        <span class="block text-[11px] opacity-70 lg:text-[14px]">{{ $totalActivities }} activities</span>
                    </span>
                </a>
                @foreach ($locations as $location)
                    <a href="{{ route('activities.index', ['location' => $location->slug]) }}"
                       @class(['pg-loc-tab', 'is-active' => $currentLocation?->is($location)])>
                        <img src="{{ $location->image_url }}" alt="" class="size-9 shrink-0 rounded-xl object-cover lg:size-14 lg:rounded-2xl">
                        <span class="text-left">
                            <span class="block whitespace-nowrap font-semibold">{{ $location->name }}</span>
                            <span class="block text-[11px] opacity-70 lg:text-[14px]">{{ $location->activities_count }} activities</span>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Mobile grid --}}
        <div class="mt-8 flex flex-col gap-6 lg:hidden">
            @forelse ($activities as $index => $activity)
                @include('components.place-card-mobile', [
                    'delay'       => ($index % 3) * 90,
                    'name'        => $activity['name'],
                    'description' => $activity['plain_description'],
                    'rating'      => $activity['rating'],
                    'image'       => $activity['image_url'],
                    'meta'        => $activity['meta'],
                    'price'       => $activity['price_label'],
                    'href'        => route('activities.show', $activity),
                ])
            @empty
                @include('partials.activity.empty')
            @endforelse

            <div class="mt-4">
                @include('components.pagination-mobile', ['paginator' => $activities, 'simple' => true])
            </div>
        </div>

        {{-- Desktop grid --}}
        <div class="hidden pt-[64px] lg:block">
            @if ($activities->isEmpty())
                @include('partials.activity.empty')
            @else
                <div class="grid [&>*]:min-w-0 justify-items-center gap-x-[52px] gap-y-[70px] sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($activities as $index => $activity)
                        @include('components.place-card', [
                            'delay'       => ($index % 3) * 90,
                            'name'        => $activity['name'],
                            'description' => $activity['plain_description'],
                            'rating'      => $activity['rating'],
                            'image'       => $activity['image_url'],
                            'meta'        => $activity['meta'],
                            'price'       => $activity['price_label'],
                            'badge'       => $activity->place_label,
                            'href'        => route('activities.show', $activity),
                        ])
                    @endforeach
                </div>

                <div class="mt-[71px]">
                    @include('components.pagination', ['paginator' => $activities])
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

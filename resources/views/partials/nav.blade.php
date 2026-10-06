{{-- Figma node 1:621 — Nav (sits on top of the hero image) --}}
@props(['active' => null])

@php
    $links = [
        'home'     => ['label' => 'Home',     'route' => route('home')],
        'boat'     => ['label' => 'Boat',     'route' => route('boats.index')],
        'activity' => ['label' => 'Activity', 'route' => route('activities.index')],
        'hotel'    => ['label' => 'Hotel',    'route' => route('hotels.index')],
        'artikel'  => ['label' => 'Article',  'route' => route('articles.index')],
    ];
@endphp

{{-- Fixed glass navigation: transparent over the hero, turns solid white once the page scrolls (motion.js toggles .is-scrolled). --}}
@push('site-nav')
<div data-site-nav class="pg-nav fixed inset-x-0 top-0 z-50 hidden lg:block">
    <nav class="container-page flex items-center justify-between py-[22px]">
        <a href="{{ route('home') }}" class="group relative flex shrink-0 items-center gap-2">
            <span class="pg-nav-logo-light flex items-center gap-2">
                <img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="" class="h-[56px] w-[113px] transition-transform duration-700 ease-smooth group-hover:-rotate-6 group-hover:scale-105">
                <img src="{{ asset('images/logo/logo-word-light.svg') }}" alt="Penida Gili" class="h-[56px] w-[255px]">
            </span>
            <span class="pg-nav-logo-dark absolute inset-0 flex items-center gap-2">
                <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[56px] w-[105px] transition-transform duration-700 ease-smooth group-hover:-rotate-6 group-hover:scale-105">
                <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="" class="h-[56px] w-[212px]">
            </span>
        </a>

        <ul class="pg-nav-links relative flex items-center gap-[10px] rounded-full p-[6px] text-[17px] leading-[30px]">
            @foreach ($links as $key => $link)
                <li>
                    <a href="{{ $link['route'] }}" @class(['pg-nav-link', 'is-active' => $active === $key])>
                        {{ $link['label'] }}
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="flex items-center gap-[14px]">
            <a href="{{ route('boats.schedules') }}" class="pg-nav-ghost">
                <x-ui-icon name="ship" class="size-[20px]" /> Schedules
            </a>
            <a href="{{ \App\Models\Setting::whatsappUrl() }}" target="_blank" rel="noopener"
               class="pg-shine flex h-[56px] items-center justify-center gap-2 rounded-full bg-brand px-[30px] text-[17px] font-semibold text-on-brand
                      transition-[transform,box-shadow,background-color] duration-300 ease-smooth hover:-translate-y-0.5 hover:bg-[#2477bd] hover:shadow-lg hover:shadow-brand/30">
                Contact Us
                <x-ui-icon name="arrow-up-right" class="size-[18px]" />
            </a>
        </div>
    </nav>
</div>
@endpush
<div class="hidden h-[100px] lg:block" aria-hidden="true"></div>

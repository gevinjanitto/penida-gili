{{-- Responsive inner-page hero used by the schedules page and the destination view of activities.
     Props: image, title, subtitle, active (nav key), eyebrow, crumbs (label => url|null). Optional $slot-like `extra` HTML via @section is not used; pass `meta` as array of [icon, text]. --}}
@php
    $subtitle ??= null;
    $active ??= null;
    $eyebrow ??= null;
    $crumbs ??= [];
    $meta ??= [];
@endphp

<header class="relative isolate z-30 w-full">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ $image }}" alt="" class="pg-kenburns size-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-[#06213a]/70 via-[#06213a]/45 to-[#06213a]/80"></div>
        <svg class="pg-wave pg-wave--slow" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path fill="#f6f9fc" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/><path fill="#f6f9fc" transform="translate(1440 0)" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/></svg>
        <svg class="pg-wave" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path fill="#f6f9fc" d="M0 50c160-25 320-25 480 0s320 25 480 0 320-25 480 0v30H0z"/><path fill="#f6f9fc" transform="translate(1440 0)" d="M0 50c160-25 320-25 480 0s320 25 480 0 320-25 480 0v30H0z"/></svg>
    </div>

    @include('partials.nav', ['active' => $active])

    <div class="container-page pb-[84px] pt-[40px] lg:pb-[130px] lg:pt-[70px]">
        @if ($crumbs)
            <nav data-reveal aria-label="Breadcrumb" class="flex flex-wrap items-center gap-1.5 text-[13px] text-white/70 lg:text-[16px]">
                @foreach ($crumbs as $label => $url)
                    @if ($url)
                        <a href="{{ $url }}" class="transition-colors hover:text-white">{{ $label }}</a>
                        <x-ui-icon name="chevron-right" class="size-3.5 lg:size-4" />
                    @else
                        <span class="font-semibold text-white">{{ $label }}</span>
                    @endif
                @endforeach
            </nav>
        @endif

        @if ($eyebrow)
            <span data-reveal style="--reveal-delay: 60ms" class="mt-4 inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/15 px-3 py-1 text-[12px] font-semibold uppercase tracking-[0.14em] text-white backdrop-blur lg:mt-6 lg:px-4 lg:py-1.5 lg:text-[14px]">
                <span class="size-1.5 rounded-full bg-sky-300 lg:size-2"></span>{{ $eyebrow }}
            </span>
        @endif

        <h1 data-reveal="blur" style="--reveal-delay: 120ms" class="mt-3 max-w-[1100px] text-[30px] font-bold leading-[1.15] tracking-[-0.02em] text-white lg:mt-5 lg:text-[64px]">
            {!! $title !!}
        </h1>

        @if ($subtitle)
            <p data-reveal style="--reveal-delay: 200ms" class="mt-3 max-w-[760px] text-[15px] leading-[1.7] text-white/80 lg:mt-5 lg:text-[19px]">{{ $subtitle }}</p>
        @endif

        @if ($meta)
            <ul data-reveal style="--reveal-delay: 260ms" class="mt-5 flex flex-wrap gap-2 lg:mt-8 lg:gap-3">
                @foreach ($meta as [$icon, $text])
                    <li class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1.5 text-[13px] font-medium text-white backdrop-blur lg:px-5 lg:py-2.5 lg:text-[16px]">
                        <x-ui-icon :name="$icon" class="size-4 lg:size-5" /> {{ $text }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</header>

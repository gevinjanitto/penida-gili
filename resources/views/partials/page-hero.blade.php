{{-- Short banner hero shared by the inner listing pages (Figma: 311px tall). --}}
@props(['image', 'title', 'subtitle', 'active'])

<header class="relative min-h-[193px] w-full overflow-hidden pb-[24px] lg:h-[311px] lg:min-h-0 lg:pb-0">
    <img src="{{ $image }}" alt="" class="pg-kenburns absolute inset-0 size-full object-cover object-bottom">
    <div class="absolute inset-0 bg-gradient-to-b from-[#06213a]/55 via-[#06213a]/25 to-[#06213a]/60"></div>
    <svg class="pg-wave pg-wave--slow" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path fill="#fff" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/><path fill="#fff" transform="translate(1440 0)" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/></svg>

    <div class="relative z-10">
        @include('partials.nav', ['active' => $active])

        <div class="container-page mt-[7px] text-center">
            <h1 data-reveal="blur" class="tracking-[-0.02em] text-[24px] lg:text-[48px] font-bold leading-[30px] lg:leading-[60px] text-on-hero">{{ $title }}</h1>
            <p data-reveal style="--reveal-delay: 100ms"
               class="mx-auto mt-[4px] max-w-[888px] text-[16px] leading-[30px] text-on-hero-muted">
                {{ $subtitle }}
            </p>
        </div>
    </div>
</header>

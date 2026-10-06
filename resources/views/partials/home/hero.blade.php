{{-- Home hero (desktop): full-bleed photo, headline, two-tab search (Boat / Where To?) and live stats. --}}
<header class="relative isolate z-30 min-h-[1080px] w-full">
    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ asset('images/home/hero-home.png') }}" alt="" class="pg-kenburns size-full object-cover object-bottom">
        <div class="absolute inset-0 bg-gradient-to-r from-[#06213a]/75 via-[#06213a]/35 to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-[420px] bg-gradient-to-t from-[#06213a]/70 to-transparent"></div>
        <svg class="pg-wave pg-wave--slow !h-[110px]" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path fill="#fff" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/><path fill="#fff" transform="translate(1440 0)" d="M0 40c120-20 240-30 360-20s240 40 360 40 240-30 360-40 240 0 360 20v50H0z"/></svg>
        <svg class="pg-wave !h-[110px]" viewBox="0 0 1440 70" preserveAspectRatio="none" aria-hidden="true"><path fill="#fff" d="M0 50c160-25 320-25 480 0s320 25 480 0 320-25 480 0v30H0z"/><path fill="#fff" transform="translate(1440 0)" d="M0 50c160-25 320-25 480 0s320 25 480 0 320-25 480 0v30H0z"/></svg>
    </div>

    @include('partials.nav', ['active' => 'home'])

    <div class="container-page pb-[170px] pt-[70px]">
        <span data-reveal class="inline-flex items-center gap-3 rounded-full border border-white/25 bg-white/15 px-[22px] py-[10px] text-[16px] font-semibold uppercase tracking-[0.18em] text-white backdrop-blur-xl">
            <span class="relative flex size-2.5"><span class="absolute inline-flex size-full animate-ping rounded-full bg-sky-300 opacity-75"></span><span class="relative inline-flex size-2.5 rounded-full bg-sky-300"></span></span>
            Boat Book
        </span>

        <h1 data-reveal="blur" style="--reveal-delay: 100ms" class="mt-[28px] max-w-[1080px] text-[84px] font-bold leading-[1.04] tracking-[-0.035em] text-white">
            Explore Tropical Island Beauty <span class="bg-gradient-to-r from-sky-200 to-white bg-clip-text text-transparent">Without Limits</span>
        </h1>

        <p data-reveal style="--reveal-delay: 200ms" class="mt-[24px] max-w-[760px] text-[20px] leading-[1.7] text-white/80">
            Book fast boat tickets and private charters to your dream destinations in minutes.
            Safe, comfortable, and hassle-free journeys.
        </p>

        <div data-reveal style="--reveal-delay: 320ms" class="mt-[44px]">
            @include('partials.search.widget', ['variant' => 'hero'])
        </div>

        <dl data-reveal style="--reveal-delay: 440ms" class="mt-[56px] flex flex-wrap gap-[64px] text-white">
            @foreach ([['12', '+', 'Daily crossings'], ['4', '', 'Island destinations'], ['4.9', '', 'Average guest rating'], ['24', '/7', 'Local support']] as [$n, $suffix, $label])
                <div>
                    <dt class="text-[46px] font-bold leading-none tracking-tight"><span data-count="{{ $n }}" data-suffix="{{ $suffix }}" data-decimals="{{ str_contains($n, '.') ? 1 : 0 }}">0</span></dt>
                    <dd class="mt-2 text-[16px] text-white/70">{{ $label }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
</header>

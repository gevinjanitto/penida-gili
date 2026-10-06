{{-- Figma node 1:3398 — "Hotels details full" (mobile, 390px). Rendered below lg only; the desktop layout is hidden there. --}}
@props(['hotel'])

@php
    // Mobile shows the first four amenities with its own icon set (keyed by the desktop icon name).
    $mAmenityIcon = [
        'wifi.svg'       => ['file' => 'amenity-wifi.svg',       'w' => 24, 'h' => 17],
        'pool.svg'       => ['file' => 'amenity-pool.svg',       'w' => 20, 'h' => 18],
        'spa.svg'        => ['file' => 'amenity-spa.svg',        'w' => 20, 'h' => 20],
        'restaurant.svg' => ['file' => 'amenity-restaurant.svg', 'w' => 15, 'h' => 20],
    ];
@endphp

<div class="bg-[#f7fafc] lg:hidden">
    {{-- Hero (1:3442) --}}
    <header class="relative h-[320px] w-full overflow-hidden">
        <img src="{{ $hotel['gallery_photos'][0]['url'] }}" alt="{{ $hotel['gallery_photos'][0]['alt'] }}" class="absolute inset-0 size-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

        <div class="absolute inset-x-[20px] bottom-[16px] flex items-end justify-between gap-[12px]">
            <div data-reveal>
                <h1 class="text-[28px] font-bold leading-[36px] text-white">{{ $hotel['name'] }}</h1>
                <p class="mt-[4px] flex items-center gap-[4px] text-[16px] leading-[24px] text-white/90">
                    <img src="{{ asset('images/icons/mobile/detail/pin-white.svg') }}" alt="" class="h-[13.3px] w-[10.7px]">
                    {{ $hotel['address'] }}
                </p>
            </div>

            <span data-reveal style="--reveal-delay: 90ms" class="flex shrink-0 items-center gap-[4px] rounded-[8px] bg-[#f7fafc] px-[12px] py-[4px] shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)]">
                <img src="{{ asset('images/icons/mobile/detail/star-rating.svg') }}" alt="" class="h-[14.3px] w-[15px]">
                <span class="text-[16px] font-bold leading-[24px] text-brand">{{ $hotel['rating'] }}</span>
            </span>
        </div>
    </header>

    <div class="flex flex-col gap-[32px] px-[20px] pb-[32px] pt-[16px]">
        {{-- Swipeable photo strip: every gallery photo, not just the hero. --}}
        @if (count($hotel['gallery_photos']) > 1)
            <div class="-mx-[20px] flex snap-x snap-mandatory gap-[10px] overflow-x-auto px-[20px] pb-[4px] [scrollbar-width:none]" data-testid="hotel-mobile-gallery">
                @foreach (array_slice($hotel['gallery_photos'], 1) as $photo)
                    <button type="button" data-lightbox-group="hotel-m" data-lightbox="{{ $photo['url'] }}" data-lightbox-alt="{{ $photo['alt'] }}"
                            class="h-[96px] w-[140px] shrink-0 snap-start overflow-hidden rounded-[12px] bg-[#e0e3e5]">
                        <img src="{{ $photo['url'] }}" alt="{{ $photo['alt'] }}" loading="lazy" class="size-full object-cover">
                    </button>
                @endforeach
            </div>
        @endif

        {{-- Description (1:3460) --}}
        <div data-reveal class="rich-text text-[16px] leading-[24px] text-[#414751]">{!! $hotel['description'] !!}</div>

        @if (! empty($hotel['highlights']))
            <section class="flex flex-col gap-[12px]">
                <h2 data-reveal class="text-[20px] font-bold leading-[30px] text-brand">Why Guests Love It</h2>
                @foreach ($hotel['highlights'] as $index => $highlight)
                    <article data-reveal style="--reveal-delay: {{ $index * 60 }}ms" class="rounded-[12px] border border-[#e5e9eb] bg-white p-[16px]">
                        <h3 class="text-[16px] font-semibold leading-[24px] text-[#181c1e]">{{ $highlight['title'] }}</h3>
                        <p class="mt-[4px] text-[14px] leading-[22px] text-[#414751]">{{ $highlight['body'] }}</p>
                    </article>
                @endforeach
            </section>
        @endif

        {{-- Amenities (1:3462) --}}
        <section class="flex flex-col gap-[16px]">
            <h2 data-reveal class="text-[20px] font-bold leading-[30px] text-brand">Amenities</h2>

            <ul class="grid grid-cols-2 gap-[16px]">
                @foreach (array_slice($hotel['amenities'], 0, 4) as $index => $amenity)
                    @php $icon = $mAmenityIcon[$amenity['icon']] ?? null; @endphp
                    <li data-reveal style="--reveal-delay: {{ $index * 60 }}ms" class="flex min-h-[56px] items-center gap-[12px] rounded-[12px] bg-[#f1f4f6] p-[16px]">
                        <img src="{{ $icon ? asset('images/icons/mobile/detail/'.$icon['file']) : asset('images/icons/hotel/'.$amenity['icon']) }}" alt=""
                             class="shrink-0 object-contain" style="width: {{ $icon['w'] ?? 20 }}px; height: {{ $icon['h'] ?? 20 }}px">
                        <span class="text-[16px] leading-[24px] text-[#181c1e]">{{ $amenity['shortLabel'] ?? $amenity['label'] }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        {{-- Select Room (1:3486) --}}
        <section class="flex flex-col gap-[16px]">
            <h2 data-reveal class="text-[20px] font-bold leading-[30px] text-brand">Select Room</h2>

            <div class="flex flex-col gap-[16px]">
                @foreach ($hotel['rooms'] as $index => $room)
                    @php $selected = $loop->last; @endphp
                    <article data-reveal style="--reveal-delay: {{ $index * 90 }}ms"
                             @class([
                                 'relative flex flex-col gap-[12px] overflow-hidden rounded-[12px] border bg-white p-[17px]',
                                 'border-brand shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]' => $selected,
                                 'border-[#c0c7d3] drop-shadow-[0px_1px_1px_rgba(0,0,0,0.05)]' => ! $selected,
                             ])>
                        @if ($selected)
                            <span class="absolute right-0 top-0 rounded-bl-[8px] bg-brand px-[8px] py-[4px] text-[10px] font-bold uppercase leading-[15px] tracking-[0.5px] text-white">Popular</span>
                        @endif

                        <div class="flex items-start justify-between gap-[12px]">
                            <div>
                                <h3 class="text-[18px] leading-[27px] text-[#181c1e]">{{ $room['name'] }}</h3>
                                <p class="text-[14px] leading-[21px] text-[#414751]">{{ $room['bed'] }} • {{ $room['guests_label'] }}</p>
                            </div>
                            <p class="shrink-0 whitespace-nowrap pt-[2px]">
                                <span class="text-[16px] font-bold leading-[24px] text-brand">{{ $room['price_label'] }}</span>
                                <span class="text-[12px] leading-[18px] text-[#414751]">/night</span>
                            </p>
                        </div>

                        <a href="{{ route('hotels.order', [$hotel['slug'], 'room' => $room['id']]) }}"
                           @class([
                               'flex items-center justify-center rounded-[8px] text-[14px] font-semibold leading-[20px] tracking-[0.7px] transition-colors duration-300',
                               'bg-brand py-[8px] text-white' => $selected,
                               'border border-[#2178c3] bg-[rgba(33,120,195,0.1)] py-[9px] text-brand active:bg-[rgba(33,120,195,0.2)]' => ! $selected,
                           ])>
                            {{ $selected ? 'Selected' : 'Select Room' }}
                        </a>
                    </article>
                @endforeach
            </div>
        </section>

        {{-- Location (1:3516) --}}
        <section class="flex flex-col gap-[8px]">
            <h2 data-reveal class="text-[20px] font-bold leading-[30px] text-brand">Location</h2>

            <div data-reveal class="relative h-[220px] overflow-hidden rounded-[12px] bg-[#e0e3e5] shadow-[0px_1px_2px_0px_rgba(0,0,0,0.05)]">
                <iframe src="{{ $hotel['map_embed_url'] }}" title="Map of {{ $hotel['name'] }}" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade" class="size-full border-0"></iframe>
            </div>

            <p class="text-center text-[14px] leading-[21px] text-[#414751]">{{ $hotel['full_address'] ?: $hotel['address'] }}</p>
            <a href="{{ $hotel['map_directions_url'] }}" target="_blank" rel="noopener"
               class="mx-auto rounded-full border border-brand/30 px-[18px] py-[7px] text-[14px] font-semibold text-brand active:bg-brand/10">Get Directions</a>

            @if (! empty($hotel['nearby']))
                <ul class="mt-[8px] flex flex-col">
                    @foreach ($hotel['nearby'] as $place)
                        <li class="flex items-center justify-between gap-[12px] border-b border-[#e5e9eb] py-[10px] text-[14px] leading-[21px]">
                            <span class="text-[#181c1e]">{{ $place['name'] }}</span>
                            <span class="shrink-0 text-[#414751]">{{ $place['distance'] }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        @if (! empty($hotel['policies']))
            <section class="flex flex-col gap-[12px]">
                <h2 data-reveal class="text-[20px] font-bold leading-[30px] text-brand">Good to Know</h2>
                <dl class="overflow-hidden rounded-[12px] border border-[#e5e9eb]">
                    @foreach ($hotel['policies'] as $policy)
                        <div class="flex items-start justify-between gap-[12px] border-b border-[#e5e9eb] bg-white p-[14px] last:border-b-0">
                            <dt class="shrink-0 text-[13px] font-semibold uppercase tracking-[0.6px] text-brand">{{ $policy['label'] }}</dt>
                            <dd class="text-right text-[14px] leading-[21px] text-[#181c1e]">{{ $policy['value'] }}</dd>
                        </div>
                    @endforeach
                </dl>
            </section>
        @endif
    </div>

    {{-- Prominent booking action (1:3527) --}}
    <div class="flex h-[80px] items-center justify-between border-t border-[#c0c7d3] bg-white px-[20px] drop-shadow-[0px_-4px_10px_rgba(0,0,0,0.05)]">
        <div>
            <p class="text-[12px] leading-[18px] text-[#414751]">Total for {{ $hotel['default_nights'] }} nights</p>
            <p class="text-[22px] font-bold leading-[33px] text-brand">{{ $hotel['default_total_label'] }}</p>
        </div>
        <a href="{{ route('hotels.order', $hotel['slug']) }}"
           class="rounded-[12px] bg-brand px-[32px] py-[12px] text-[14px] font-semibold leading-[20px] tracking-[0.7px] text-white shadow-[0px_10px_15px_-3px_rgba(0,0,0,0.1),0px_4px_6px_-4px_rgba(0,0,0,0.1)] transition-transform duration-300 ease-smooth active:scale-[0.98]">
            Book Now
        </a>
    </div>
</div>

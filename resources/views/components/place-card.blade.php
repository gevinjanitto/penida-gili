{{-- Figma nodes 1:628 (Activity) / 1:951 (Hotel) — Destination Card, 642px tall.

     The two pages share this shell and differ only in how many meta items sit
     above the price, so `meta` is a list of ['icon' => …, 'label' => …]. --}}
@props([
    'name',
    'description',
    'rating',
    'image',
    'price',
    'meta' => [],
    'href' => '#',
    'delay' => 0,
])

<a href="{{ $href }}" data-reveal style="--reveal-delay: {{ $delay }}ms"
   class="group flex w-full max-w-[472px] flex-col lg:h-[642px] rounded-[30px] border border-slate-100 bg-surface p-[16px] pb-[24px] shadow-card
          transition-[transform,box-shadow,border-color] duration-500 ease-smooth
          hover:-translate-y-2 hover:border-brand/20 hover:shadow-card-hover">
    <div class="relative h-[257px] w-full overflow-hidden rounded-[18px]">
        <img src="{{ $image }}" alt="{{ $name }}" loading="lazy"
             class="pg-zoom size-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/35 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
        @if (! empty($badge))
            <span class="absolute left-[16px] top-[16px] inline-flex items-center gap-[6px] rounded-full bg-white/90 px-[14px] py-[6px] text-[14px] font-semibold text-[#0b2540] backdrop-blur">
                <x-ui-icon name="pin" class="size-[15px] text-brand" /> {{ $badge }}
            </span>
        @endif
    </div>

    @if ((float) $rating > 0)
        <div class="mt-[23px] flex items-center gap-[19px]">
            <x-rating-stars :rating="$rating" />
            <span class="text-[16px] leading-[30px] text-ink">{{ $rating }}</span>
        </div>
    @endif

    <h3 class="mt-[20px] text-[24px] font-bold tracking-tight leading-[32px] text-[#0b2540] transition-colors duration-300 group-hover:text-brand">
        {{ $name }}
    </h3>

    <p class="mt-[14px] line-clamp-3 text-[16px] leading-[30px] text-ink-muted">{{ $description }}</p>

    <ul class="mt-auto flex flex-wrap items-start gap-[15px] text-[15.3px] leading-[23px] text-[#414751]">
        @foreach ($meta as $item)
            <li class="flex items-center gap-[7.7px]">
                <img src="{{ asset('images/icons/meta/'.$item['icon']) }}" alt="" class="size-[19px] object-contain">
                {{ $item['label'] }}
            </li>
        @endforeach
    </ul>

    <div class="mt-[16px] flex items-end justify-between">
        <div>
            <p class="text-[16px] leading-[30px] text-ink-muted">Start from</p>
            <p class="text-[24px] font-bold leading-[30px] text-ink">{{ $price }}</p>
        </div>

        <span class="grid size-[54px] place-items-center rounded-full bg-[#eaf3fb] text-brand transition-[transform,background-color,color] duration-500 ease-smooth group-hover:-rotate-45 group-hover:bg-brand group-hover:text-white">
            <x-ui-icon name="arrow-right" class="size-[22px]" />
        </span>
    </div>
</a>

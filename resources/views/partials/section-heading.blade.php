{{-- Shared section heading: eyebrow + display title (+ optional right-aligned intro) --}}
@props(['eyebrow', 'title', 'intro' => null])

<div class="grid gap-x-[113px] gap-y-6 lg:grid-cols-2">
    <div data-reveal>
        <p class="inline-flex items-center gap-3 text-[16px] font-semibold uppercase tracking-[0.18em] leading-[30px] text-brand before:block before:h-[2px] before:w-10 before:rounded-full before:bg-brand">{{ $eyebrow }}</p>
        <h2 class="mt-[24px] max-w-[827px] text-[30px] font-bold tracking-[-0.03em] lg:text-[64px] leading-[1.15] lg:leading-[1.08] text-[#0b2540]">{!! $title !!}</h2>
    </div>

    @if ($intro)
        <p data-reveal style="--reveal-delay: 120ms"
           class="max-w-[585px] text-[16px] leading-[30px] text-ink-muted lg:self-end lg:pb-[14px] lg:text-[18px] lg:leading-[1.8]">{{ $intro }}</p>
    @endif
</div>

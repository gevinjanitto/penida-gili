{{-- Four boat fares (Schedule::fares()) — Domestic / Foreign × Adult / Child.
     $fares: ['domestic' => ['adult','child'], 'foreign' => [...]]
     $active: 'domestic' | 'foreign' | null — on order pages order-quote.js moves it with the nationality.
     $size:   'sm' (cards, mobile) | 'md' (desktop summary). --}}
@php
    $active ??= null;
    $size ??= 'sm';
    $md = $size === 'md';
    $cols = [
        'domestic' => ['Domestic', 'Indonesian passport', 'text-brand', 'bg-brand/[0.06]'],
        'foreign' => ['Foreign', 'Other nationalities', 'text-[#b45309]', 'bg-[#fff7ed]'],
    ];
@endphp

<div @class(["grid gap-[6px]", "xl:grid-cols-2" => $md]) data-fare-table data-testid="fare-table">
    @foreach ($cols as $type => [$title, $note, $tone, $bg])
        <div data-fare-col="{{ $type }}"
             @class([
                 'pg-fare-col min-w-0 rounded-[12px] border p-[10px] transition-[border-color,box-shadow] duration-300',
                 $bg,
                 'is-active' => $active === $type,
                 'lg:p-[12px]' => $md,
             ])>
            <p @class(['flex items-center justify-between gap-[6px] font-bold uppercase tracking-[0.12em]', $tone, 'text-[11px]', 'lg:text-[13px]' => $md])>
                <span>{{ $title }}</span>
                <span class="pg-fare-check hidden size-[16px] items-center justify-center rounded-full bg-current" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.2" class="size-[10px]"><path d="m5 12.5 4.5 4.5L19 7.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </p>
            <p class="text-[11px] leading-[16px] text-[#717782]">{{ $note }}</p>

            <dl class="mt-[8px] grid grid-cols-2 gap-[5px]">
                @foreach (['adult' => 'Adult', 'child' => 'Child'] as $who => $label)
                    <div class="min-w-0 rounded-[8px] bg-white px-[6px] py-[6px] shadow-[0_1px_2px_rgba(16,24,40,0.05)]">
                        <dt class="text-[11px] leading-[15px] text-[#717782]">{{ $label }}</dt>
                        <dd @class(['whitespace-nowrap font-bold leading-[18px] text-[#181c1e] tabular-nums', 'text-[12px]', 'lg:text-[13px]' => $md])
                            data-testid="fare-{{ $type }}-{{ $who }}">{{ \App\Support\Money::idr($fares[$type][$who], 'Rp') }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    @endforeach
</div>

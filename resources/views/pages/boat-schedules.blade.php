{{-- Fast boat schedule search results (hero "Boat" tab). --}}
@extends('layouts.app')

@section('title', 'Fast Boat Schedules')

@php
    use App\Support\Money;
    use Illuminate\Support\Carbon;

    $routeTitle = ($search['from'] ?: 'All ports').' <span class="inline-block align-middle text-sky-300">&rarr;</span> '.($search['to'] ?: 'All destinations');
    $timeFilters = [
        ''          => ['All sailings', 'ship', $total],
        'morning'   => ['Morning · before 12:00', 'sunrise', $counts['morning'] ?? 0],
        'afternoon' => ['Afternoon · 12:00 – 17:00', 'sun', $counts['afternoon'] ?? 0],
        'evening'   => ['Evening · after 17:00', 'sunset', $counts['evening'] ?? 0],
    ];
    $facilityIcons = ['Air Conditioning' => 'wind', 'Toilet' => 'check', 'Life Jackets' => 'life-buoy', 'Insurance' => 'shield'];
    $query = fn (array $over) => route('boats.schedules', array_filter(array_merge($search, $over), fn ($v) => $v !== '' && $v !== null));
@endphp

@section('hero')
    @include('partials.hero-banner', [
        'image'    => asset('images/boats/hero-boat.png'),
        'active'   => 'boat',
        'eyebrow'  => 'Fast Boat Schedules',
        'title'    => $routeTitle,
        'crumbs'   => ['Home' => route('home'), 'Boat' => route('boats.index'), 'Schedules' => null],
        'meta'     => [
            ['calendar', $date->format('l, j F Y')],
            ['users', $search['guests'].' '.str('guest')->plural($search['guests'])],
            ['ship', $total.' '.str('sailing')->plural($total)],
        ],
    ])
@endsection

@section('content')
<section class="bg-[#f6f9fc] pb-[90px] lg:pb-[140px]">
    <div class="container-page grid gap-6 lg:grid-cols-[440px_minmax(0,1fr)] lg:gap-[40px]">
        {{-- ============ Sidebar ============ --}}
        <aside class="relative z-[35] -mt-[50px] flex flex-col gap-4 lg:-mt-[80px] lg:gap-6">
            <div data-reveal class="rounded-[24px] border border-slate-100 bg-white p-4 shadow-[0_20px_60px_-25px_rgba(6,30,56,0.25)] lg:rounded-[30px] lg:p-6">
                <p class="mb-3 flex items-center gap-2 text-[13px] font-semibold uppercase tracking-[0.12em] text-slate-400 lg:mb-4 lg:text-[14px]">
                    <x-ui-icon name="search" class="size-4" /> Change search
                </p>
                @include('partials.search.widget', ['variant' => 'panel', 'tab' => 'boat', 'search' => $search])
            </div>

            <div data-reveal style="--reveal-delay: 90ms" class="rounded-[24px] border border-slate-100 bg-white p-4 lg:rounded-[30px] lg:p-6">
                <p class="flex items-center gap-2 text-[15px] font-bold text-slate-900 lg:text-[18px]">
                    <x-ui-icon name="sliders" class="size-4 text-brand lg:size-5" /> Departure time
                </p>
                <ul class="mt-3 flex flex-col gap-1.5 lg:mt-4 lg:gap-2">
                    @foreach ($timeFilters as $key => [$label, $icon, $count])
                        <li>
                            <a href="{{ $query(['time' => $key]) }}"
                               @class([
                                   'group flex items-center gap-3 rounded-2xl px-3 py-2.5 text-[14px] transition-[background-color,color,transform] duration-300 ease-smooth hover:translate-x-1 lg:px-4 lg:py-3.5 lg:text-[16px]',
                                   'bg-brand text-white shadow-lg shadow-brand/25' => $search['time'] === $key,
                                   'text-slate-600 hover:bg-slate-50' => $search['time'] !== $key,
                               ])>
                                <x-ui-icon :name="$icon" class="size-4 lg:size-5" />
                                <span class="flex-1 font-medium">{{ $label }}</span>
                                <span @class(['rounded-full px-2 py-0.5 text-[12px] font-bold lg:text-[13px]', 'bg-white/20' => $search['time'] === $key, 'bg-slate-100 text-slate-500' => $search['time'] !== $key])>{{ $count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div data-reveal style="--reveal-delay: 160ms" class="hidden overflow-hidden rounded-[30px] bg-[#0b2540] p-6 text-white lg:block">
                <x-ui-icon name="anchor" class="pg-float size-10 text-sky-300" />
                <p class="mt-4 text-[20px] font-bold">Need a private boat?</p>
                <p class="mt-2 text-[15px] leading-relaxed text-white/70">Charter a speed boat for your group, any time of day. Our team replies within minutes.</p>
                <a href="{{ \App\Models\Setting::whatsappUrl() }}" target="_blank" rel="noopener"
                   class="pg-shine mt-5 inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-[15px] font-semibold text-[#0b2540] transition-transform duration-300 hover:-translate-y-0.5">
                    Chat on WhatsApp <x-ui-icon name="arrow-right" class="size-4" />
                </a>
            </div>
        </aside>

        {{-- ============ Results ============ --}}
        <div class="min-w-0 pt-2 lg:pt-[40px]">
            {{-- Date strip --}}
            <div data-reveal class="flex items-stretch gap-2 overflow-x-auto pb-2 [scrollbar-width:none] lg:gap-3">
                @for ($i = -3; $i <= 3; $i++)
                    @php $d = $date->copy()->addDays($i); @endphp
                    @continue($d->lt(Carbon::today()))
                    <a href="{{ $query(['date' => $d->toDateString()]) }}"
                       @class([
                           'flex min-w-[78px] flex-col items-center rounded-2xl border px-3 py-2.5 transition-[transform,background-color,border-color,box-shadow] duration-300 ease-smooth hover:-translate-y-1 lg:min-w-[118px] lg:py-4',
                           'border-brand bg-brand text-white shadow-lg shadow-brand/30' => $i === 0,
                           'border-slate-200 bg-white text-slate-700 hover:border-brand/40' => $i !== 0,
                       ])>
                        <span class="text-[11px] font-semibold uppercase tracking-wider opacity-70 lg:text-[13px]">{{ $d->format('D') }}</span>
                        <span class="text-[18px] font-bold lg:text-[24px]">{{ $d->format('j') }}</span>
                        <span class="text-[11px] opacity-70 lg:text-[13px]">{{ $d->format('M') }}</span>
                    </a>
                @endfor
            </div>

            <div class="mt-5 flex flex-wrap items-center justify-between gap-3 lg:mt-8">
                <p class="text-[15px] text-slate-500 lg:text-[18px]">
                    <span class="font-bold text-slate-900">{{ $schedules->count() }}</span> {{ str('sailing')->plural($schedules->count()) }} found
                    @if ($cheapest) · from <span class="font-bold text-brand">{{ Money::idr($cheapest) }}</span> @endif
                </p>
                <div class="inline-flex rounded-full bg-white p-1 shadow-sm ring-1 ring-slate-100">
                    @foreach (['departure' => 'Earliest', 'price' => 'Cheapest'] as $key => $label)
                        <a href="{{ $query(['sort' => $key]) }}"
                           @class(['rounded-full px-4 py-1.5 text-[13px] font-semibold transition-colors duration-300 lg:px-6 lg:py-2.5 lg:text-[15px]', 'bg-slate-900 text-white' => $search['sort'] === $key, 'text-slate-500 hover:text-slate-900' => $search['sort'] !== $key])>{{ $label }}</a>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 flex flex-col gap-5 lg:mt-7 lg:gap-7">
                @forelse ($schedules as $index => $schedule)
                    @php
                        $vessel = $schedule->vessel;
                        $operator = $schedule->operator;
                        $image = $vessel?->image_url ?? $operator->image_url ?? asset('images/placeholder.svg');
                        $rating = (float) ($vessel?->rating ?? $operator->rating);
                        $minutes = $schedule->duration_minutes;
                        $duration = $minutes >= 60 ? intdiv($minutes, 60).'h '.($minutes % 60 ? ($minutes % 60).'m' : '') : $minutes.'m';
                        $facilities = collect($vessel?->facilities ?: $operator->facilities ?: [])->map(fn ($f) => is_array($f) ? ($f['label'] ?? '') : (string) $f)->filter();
                        $orderUrl = route('boats.order', [$operator, 'schedule' => $schedule->id, 'date' => $search['date'], 'adults' => $search['guests']]);
                    @endphp

                    <article data-reveal style="--reveal-delay: {{ min($index, 5) * 70 }}ms"
                             class="group relative grid overflow-hidden rounded-[24px] border border-slate-100 bg-white shadow-[0_10px_40px_-24px_rgba(6,30,56,0.35)] transition-[box-shadow,border-color] duration-500 ease-smooth hover:border-brand/30 hover:shadow-[0_30px_70px_-30px_rgba(6,30,56,0.45)] md:grid-cols-[230px_minmax(0,1fr)] lg:rounded-[30px] xl:grid-cols-[300px_minmax(0,1fr)_250px]">
                        {{-- Photo --}}
                        <div class="relative h-[190px] overflow-hidden md:h-full md:min-h-[230px]">
                            <img src="{{ $image }}" alt="{{ $vessel?->name }}" loading="lazy" class="pg-zoom absolute inset-0 size-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-transparent to-transparent"></div>
                            <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-brand backdrop-blur lg:left-4 lg:top-4 lg:text-[12px]">
                                <span class="size-1.5 animate-pulse rounded-full bg-emerald-500"></span> Departure
                            </span>
                            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1 rounded-full bg-black/40 px-2.5 py-1 text-[12px] font-semibold text-white backdrop-blur lg:bottom-4 lg:left-4 lg:text-[14px]">
                                <x-ui-icon name="star" class="size-3.5 fill-amber-400 text-amber-400" /> {{ number_format($rating, 1) }}
                            </span>
                        </div>

                        {{-- Body --}}
                        <div class="min-w-0 p-4 lg:p-7">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="flex items-center gap-0.5">
                                        @for ($s = 1; $s <= 5; $s++)
                                            <x-ui-icon name="star" @class(['size-3.5 lg:size-4', 'fill-amber-400 text-amber-400' => $s <= round($rating), 'text-slate-300' => $s > round($rating)]) />
                                        @endfor
                                    </div>
                                    @if ($vessel)
                                        <a href="{{ route('boats.vessel', $vessel) }}" class="group/name mt-1.5 inline-flex items-center gap-1.5 text-[18px] font-bold uppercase tracking-tight text-slate-900 transition-colors hover:text-brand lg:text-[24px]">
                                            {{ $vessel->name }}
                                            <x-ui-icon name="arrow-up-right" class="size-4 -translate-x-1 opacity-0 transition-[opacity,transform] duration-300 group-hover/name:translate-x-0 group-hover/name:opacity-100 lg:size-5" />
                                        </a>
                                    @else
                                        <p class="mt-1.5 text-[18px] font-bold uppercase text-slate-900 lg:text-[24px]">{{ $operator->name }}</p>
                                    @endif
                                    <p class="text-[13px] text-slate-500 lg:text-[15px]">{{ $operator->name }}@if ($vessel) · {{ $vessel->type }} · {{ $vessel->capacity }} seats @endif</p>
                                </div>
                            </div>

                            {{-- Timeline --}}
                            <div class="mt-4 flex items-center gap-3 lg:mt-6 lg:gap-5">
                                <div>
                                    <p class="text-[24px] font-bold leading-none text-slate-900 lg:text-[34px]">{{ substr($schedule->departure_time, 0, 5) }}</p>
                                    <p class="mt-1 text-[11px] font-bold uppercase tracking-wider text-rose-500 lg:text-[13px]">{{ $schedule->from }}</p>
                                </div>
                                <div class="relative flex flex-1 flex-col items-center">
                                    <span class="text-[11px] font-semibold text-slate-400 lg:text-[13px]">{{ trim($duration) }}</span>
                                    <span class="relative mt-1 block h-[2px] w-full overflow-hidden rounded-full bg-slate-100">
                                        <span class="absolute inset-y-0 left-0 w-1/3 rounded-full bg-brand transition-[width] duration-700 ease-smooth group-hover:w-full"></span>
                                    </span>
                                    <x-ui-icon name="ship" class="absolute top-[14px] size-4 bg-white px-0.5 text-brand transition-transform duration-700 ease-smooth group-hover:translate-x-6 lg:top-[17px] lg:size-5" />
                                </div>
                                <div class="text-right">
                                    <p class="text-[24px] font-bold leading-none text-slate-900 lg:text-[34px]">{{ substr($schedule->arrival_time, 0, 5) }}</p>
                                    <p class="mt-1 text-[11px] font-bold uppercase tracking-wider text-rose-500 lg:text-[13px]">{{ $schedule->to }}</p>
                                </div>
                            </div>

                            {{-- Fares — shared with the vessel page and the order page (Schedule::fares()). --}}
                            <div class="mt-4 lg:mt-6">
                                @include('partials.boat.fare-table', ['fares' => $schedule->fares(), 'size' => 'md'])
                            </div>

                            @if ($facilities->isNotEmpty())
                                <ul class="mt-3 flex flex-wrap gap-1.5 lg:mt-4 lg:gap-2">
                                    <li class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-2.5 py-1 text-[11px] text-slate-600 lg:text-[13px]"><x-ui-icon name="luggage" class="size-3.5" /> 20kg</li>
                                    @foreach ($facilities as $facility)
                                        <li class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-2.5 py-1 text-[11px] text-slate-600 lg:text-[13px]"><x-ui-icon :name="$facilityIcons[$facility] ?? 'check'" class="size-3.5" /> {{ $facility }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        {{-- CTA --}}
                        <div class="flex items-center justify-between gap-3 border-t border-slate-100 bg-slate-50/60 p-4 md:col-span-2 xl:col-span-1 xl:flex-col xl:items-stretch xl:justify-center xl:border-l xl:border-t-0 xl:p-7">
                            <div class="xl:text-center">
                                <p class="text-[12px] text-slate-500 lg:text-[14px]">From · {{ $search['guests'] }} {{ str('adult')->plural($search['guests']) }} (domestic)</p>
                                <p class="text-[20px] font-bold text-slate-900 lg:text-[26px]">{{ Money::idr($schedule->price_adult * $search['guests']) }}</p>
                            </div>
                            <a href="{{ $orderUrl }}"
                               class="pg-shine inline-flex items-center justify-center gap-2 rounded-2xl bg-brand px-6 py-3 text-[15px] font-bold text-white shadow-lg shadow-brand/30 transition-[transform,background-color] duration-300 ease-smooth hover:-translate-y-0.5 hover:bg-[#2477bd] lg:py-4 lg:text-[17px]">
                                Select <x-ui-icon name="arrow-right" class="size-4 transition-transform duration-300 group-hover:translate-x-1" />
                            </a>
                        </div>
                    </article>
                @empty
                    <div data-reveal="zoom" class="flex flex-col items-center rounded-[30px] border border-dashed border-slate-200 bg-white px-6 py-14 text-center lg:py-20">
                        <span class="grid size-16 place-items-center rounded-full bg-sky-50 text-brand lg:size-20"><x-ui-icon name="ship" class="pg-float size-8 lg:size-10" /></span>
                        <p class="mt-5 text-[18px] font-bold text-slate-900 lg:text-[24px]">No sailings on this day</p>
                        <p class="mt-2 max-w-[440px] text-[14px] text-slate-500 lg:text-[17px]">Try another date from the strip above, swap the ports, or browse every crossing we sail.</p>
                        <a href="{{ route('boats.schedules') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand px-6 py-3 text-[15px] font-semibold text-white transition-transform hover:-translate-y-0.5">
                            See all schedules <x-ui-icon name="arrow-right" class="size-4" />
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection

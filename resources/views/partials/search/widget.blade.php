{{--
    Search widget with two tabs: "Boat" (from / to / date / guests -> schedules)
    and "Where To?" (destination -> activities in that location).
    Data ($searchPorts, $searchLocations) comes from the view composer in AppServiceProvider.
    Props: $search (from, to, date, guests, location), $tab ('boat'|'where'), $variant ('hero'|'panel').
--}}
@php
    $search = $search ?? [];
    $tab = $tab ?? 'boat';
    $variant = $variant ?? 'hero';
    $isPanel = $variant === 'panel';
    $fromValue = $search['from'] ?? '';
    $toValue = $search['to'] ?? '';
    $dateValue = $search['date'] ?? '';
    $guestsValue = (int) ($search['guests'] ?? 1) ?: 1;
    $locationValue = $search['location'] ?? '';
    $selectedLocation = $searchLocations->firstWhere('slug', $locationValue);
    $uid = 'sw'.substr(md5(uniqid('', true)), 0, 6);
@endphp

<div data-search-tabs @class(['pg-search font-jakarta', 'pg-search--panel' => $isPanel])>
    {{-- Tabs --}}
    <div role="tablist" class="pg-tabs relative inline-flex rounded-full p-1.5">
        <span data-tab-indicator class="pg-tab-indicator absolute left-0 top-1.5 bottom-1.5 rounded-full"></span>
        <button type="button" role="tab" data-tab="boat" @class(['pg-tab', 'is-active' => $tab === 'boat']) aria-selected="{{ $tab === 'boat' ? 'true' : 'false' }}">
            <x-ui-icon name="ship" class="size-[18px] lg:size-[22px]" />
            <span>Boat</span>
        </button>
        <button type="button" role="tab" data-tab="where" @class(['pg-tab', 'is-active' => $tab === 'where']) aria-selected="{{ $tab === 'where' ? 'true' : 'false' }}">
            <x-ui-icon name="compass" class="size-[18px] lg:size-[22px]" />
            <span>Where To?</span>
        </button>
    </div>

    {{-- ============================== Boat ============================== --}}
    <form data-tab-panel="boat" action="{{ route('boats.schedules') }}" method="get" @if ($tab !== 'boat') hidden @endif
          class="pg-card mt-3 lg:mt-4">
        <div class="pg-grid">
            {{-- From / To --}}
            <div class="pg-route">
                @foreach (['from' => ['From', 'Origin port', $fromValue], 'to' => ['To', 'Destination port', $toValue]] as $name => [$label, $placeholder, $value])
                    <div data-pop data-dropdown="{{ $name }}" class="pg-field relative min-w-0 flex-1">
                        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
                        <button type="button" data-pop-trigger aria-expanded="false" class="pg-trigger">
                            <span class="pg-ico"><x-ui-icon name="{{ $name === 'from' ? 'anchor' : 'pin' }}" /></span>
                            <span class="min-w-0 flex-1 text-left">
                                <span class="pg-label">{{ $label }}</span>
                                <span data-dropdown-label data-placeholder="{{ $placeholder }}" @class(['pg-value', 'is-placeholder' => ! $value])>{{ $value ?: $placeholder }}</span>
                            </span>
                            <x-ui-icon name="chevron-down" class="pg-chev size-4 lg:size-5" />
                        </button>

                        <div data-pop-panel class="pg-pop w-[min(320px,calc(100vw-48px))] lg:w-[380px]">
                            <div class="pg-pop-search">
                                <x-ui-icon name="search" class="size-4 text-slate-400" />
                                <input data-pop-filter type="text" placeholder="Search port or island" class="w-full bg-transparent text-sm lg:text-base focus:outline-none">
                            </div>
                            <div class="max-h-[280px] overflow-y-auto overscroll-contain p-2 lg:max-h-[340px]">
                                @foreach ($searchPorts as $group)
                                    <div data-option-group>
                                        <p class="px-3 pb-1 pt-3 text-[11px] font-semibold uppercase tracking-[0.12em] text-slate-400 lg:text-xs">{{ $group['group'] }}</p>
                                        @foreach ($group['ports'] as $port)
                                            <button type="button" data-option data-value="{{ $port->name }}" data-label="{{ $port->name }}" data-group="{{ $group['group'] }}"
                                                    @class(['pg-option', 'is-selected' => $value === $port->name])>
                                                <span class="pg-option-ico"><x-ui-icon name="anchor" class="size-4" /></span>
                                                <span class="flex-1 text-left">{{ $port->name }}</span>
                                                <x-ui-icon name="check" class="pg-option-check size-4" />
                                            </button>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if ($name === 'from')
                        <button type="button" data-swap aria-label="Swap origin and destination" class="pg-swap">
                            <x-ui-icon name="swap" class="size-4 lg:size-5" />
                        </button>
                    @endif
                @endforeach
            </div>

            {{-- Date --}}
            <div data-pop data-datepicker class="pg-field relative">
                <input type="hidden" name="date" value="{{ $dateValue }}">
                <button type="button" data-pop-trigger aria-expanded="false" class="pg-trigger">
                    <span class="pg-ico"><x-ui-icon name="calendar" /></span>
                    <span class="min-w-0 flex-1 text-left">
                        <span class="pg-label">Date</span>
                        <span data-date-label data-placeholder="Select date" @class(['pg-value', 'is-placeholder' => ! $dateValue])>{{ $dateValue ?: 'Select date' }}</span>
                    </span>
                    <x-ui-icon name="chevron-down" class="pg-chev size-4 lg:size-5" />
                </button>

                <div data-pop-panel class="pg-pop w-[min(320px,calc(100vw-48px))] p-4 lg:w-[360px] lg:p-5">
                    <div class="flex items-center justify-between">
                        <button type="button" data-cal-prev class="pg-cal-nav" aria-label="Previous month"><x-ui-icon name="chevron-left" class="size-4" /></button>
                        <p data-cal-title class="text-sm font-semibold text-slate-800 lg:text-base"></p>
                        <button type="button" data-cal-next class="pg-cal-nav" aria-label="Next month"><x-ui-icon name="chevron-right" class="size-4" /></button>
                    </div>
                    <div data-cal-grid class="pg-cal-grid mt-3"></div>
                    <div class="mt-3 flex gap-2 border-t border-slate-100 pt-3">
                        <button type="button" data-cal-quick="0" class="pg-chip">Today</button>
                        <button type="button" data-cal-quick="1" class="pg-chip">Tomorrow</button>
                        <button type="button" data-cal-quick="7" class="pg-chip">Next week</button>
                    </div>
                </div>
            </div>

            {{-- Guests --}}
            <div class="pg-field">
                <div class="pg-trigger cursor-default">
                    <span class="pg-ico"><x-ui-icon name="users" /></span>
                    <span class="min-w-0 flex-1 text-left">
                        <label for="{{ $uid }}-guests" class="pg-label">Guests</label>
                        <span data-guests class="mt-0.5 flex items-center gap-2">
                            <button type="button" data-guests-minus class="pg-step" aria-label="Fewer guests"><x-ui-icon name="minus" class="size-3.5 lg:size-4" /></button>
                            <input id="{{ $uid }}-guests" name="guests" type="text" inputmode="numeric" min="1" max="20" value="{{ $guestsValue }}"
                                   class="pg-guests-input" aria-label="Number of guests">
                            <button type="button" data-guests-plus class="pg-step" aria-label="More guests"><x-ui-icon name="plus" class="size-3.5 lg:size-4" /></button>
                        </span>
                    </span>
                </div>
            </div>

            <button type="submit" class="pg-submit group">
                <x-ui-icon name="search" class="size-5 transition-transform duration-500 ease-smooth group-hover:rotate-12 lg:size-6" />
                <span>Search</span>
            </button>
        </div>
    </form>

    {{-- ============================ Where To? =========================== --}}
    <form data-tab-panel="where" data-where-form action="{{ route('activities.index') }}" method="get" @if ($tab !== 'where') hidden @endif
          class="pg-card mt-3 lg:mt-4">
        <div class="pg-grid pg-grid--where">
            <div data-pop data-dropdown="location" class="pg-field relative">
                <input type="hidden" name="location" value="{{ $locationValue }}">
                <button type="button" data-pop-trigger aria-expanded="false" class="pg-trigger">
                    <span class="pg-ico"><x-ui-icon name="map" /></span>
                    <span class="min-w-0 flex-1 text-left">
                        <span class="pg-label">Destination</span>
                        <span data-dropdown-label data-placeholder="Where do you want to go?" @class(['pg-value', 'is-placeholder' => ! $selectedLocation])>{{ $selectedLocation?->name ?? 'Where do you want to go?' }}</span>
                    </span>
                    <x-ui-icon name="chevron-down" class="pg-chev size-4 lg:size-5" />
                </button>

                <div data-pop-panel class="pg-pop w-[min(340px,calc(100vw-48px))] p-2 lg:w-[460px]">
                    @foreach ($searchLocations as $location)
                        <button type="button" data-option data-value="{{ $location->slug }}" data-label="{{ $location->name }}"
                                @class(['pg-option pg-option--rich', 'is-selected' => $locationValue === $location->slug])>
                            <img src="{{ $location->image_url }}" alt="" loading="lazy" class="size-11 shrink-0 rounded-xl object-cover lg:size-14">
                            <span class="min-w-0 flex-1 text-left">
                                <span class="block font-semibold text-slate-800">{{ $location->name }}</span>
                                <span class="block truncate text-xs text-slate-500 lg:text-sm">{{ $location->tagline }}</span>
                            </span>
                            <span class="rounded-full bg-sky-50 px-2 py-0.5 text-[11px] font-semibold text-brand lg:text-xs">{{ $location->activities_count }} activities</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="pg-quick hidden md:flex">
                @foreach ($searchLocations as $location)
                    <a href="{{ route('activities.index', ['location' => $location->slug]) }}" class="pg-chip pg-chip--glass">{{ $location->name }}</a>
                @endforeach
            </div>

            <button type="submit" class="pg-submit group">
                <x-ui-icon name="compass" class="size-5 transition-transform duration-700 ease-smooth group-hover:rotate-[200deg] lg:size-6" />
                <span>Explore</span>
            </button>
        </div>
    </form>
</div>

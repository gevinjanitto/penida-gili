{{-- Admin sidebar: lucide icons, animated active pill, collapses into an off-canvas drawer below lg. --}}
@php
    $menu = [
        'Overview' => [
            'dashboard' => ['label' => 'Dashboard',      'icon' => 'layers',   'route' => route('admin.dashboard')],
            'report'    => ['label' => 'Booking Report', 'icon' => 'tag',      'route' => route('admin.report')],
        ],
        'Catalogue' => [
            'boat'      => ['label' => 'Boat',           'icon' => 'ship',     'route' => route('admin.boats')],
            'schedule'  => ['label' => 'Schedule',       'icon' => 'clock',    'route' => route('admin.schedules')],
            'location'  => ['label' => 'Locations',      'icon' => 'map',      'route' => route('admin.locations')],
            'activity'  => ['label' => 'Activity',       'icon' => 'compass',  'route' => route('admin.activities')],
            'hotel'     => ['label' => 'Hotel',          'icon' => 'anchor',   'route' => route('admin.hotels')],
            'article'   => ['label' => 'Article',        'icon' => 'edit',     'route' => route('admin.articles')],
        ],
        'Website' => [
            'settings'  => ['label' => 'Social & WhatsApp', 'icon' => 'globe', 'route' => route('admin.settings')],
        ],
    ];

    $current = trim($__env->yieldContent('admin-active')) ?: 'dashboard';
    $firstName = \Illuminate\Support\Str::before(auth()->user()?->name ?? 'Admin', ' ');
@endphp

<div data-admin-backdrop class="pg-admin-backdrop fixed inset-0 z-40 bg-[#071a2e]/50 backdrop-blur-sm lg:hidden"></div>

<aside data-admin-sidebar class="pg-admin-sidebar fixed inset-y-0 left-0 z-50 flex w-[280px] shrink-0 flex-col overflow-y-auto bg-white px-[16px] pb-[24px] pt-[24px] shadow-2xl lg:sticky lg:top-0 lg:h-screen lg:translate-x-0 lg:bg-transparent lg:shadow-none">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-[10px] px-[4px]" data-testid="admin-brand">
            <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="Penida Gili logo"
                 class="h-[34px] w-[68px] shrink-0 object-contain transition-transform duration-500 ease-smooth group-hover:-rotate-6 group-hover:scale-105">
            <span class="whitespace-nowrap text-[20px] font-extrabold leading-tight tracking-[-0.2px] text-admin-ink">
                PenidaGili <span class="font-semibold text-brand">Admin</span>
            </span>
        </a>
        <button type="button" data-admin-close class="grid size-[36px] place-items-center rounded-full text-admin-muted hover:bg-admin-canvas lg:hidden" aria-label="Close menu">
            <x-ui-icon name="x" class="size-[18px]" />
        </button>
    </div>

    <nav class="mt-[36px] flex flex-col gap-[26px]" aria-label="Admin">
        @foreach ($menu as $group => $items)
            <div>
                <p class="px-[16px] text-[12px] font-semibold uppercase tracking-[0.16em] text-admin-label">{{ $group }}</p>
                <ul class="mt-[10px] flex flex-col gap-[4px]">
                    @foreach ($items as $key => $item)
                        <li>
                            <a href="{{ $item['route'] }}" @class(['pg-admin-link', 'is-active' => $current === $key]) @if ($current === $key) aria-current="page" @endif>
                                <span class="pg-admin-link-ico"><x-ui-icon :name="$item['icon']" class="size-[19px]" /></span>
                                <span class="flex-1">{{ $item['label'] }}</span>
                                @if ($key === 'settings')
                                    <span class="rounded-full bg-[#e0f2fe] px-[7px] py-[1px] text-[10px] font-bold uppercase text-[#0369a1]">New</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    <div class="mt-auto pt-[28px]">
        <div class="relative overflow-hidden rounded-[20px] bg-[#071a2e] p-[20px] text-white">
            <div class="pointer-events-none absolute -right-10 -top-10 size-[120px] rounded-full bg-editorial/50 blur-2xl"></div>
            <p class="relative text-[13px] text-white/60">Signed in as</p>
            <p class="relative mt-[2px] text-[20px] font-bold">Hi, {{ $firstName }}!</p>
            <p class="relative mt-[4px] text-[12px] leading-[1.5] text-white/60">Full administrative access is granted.</p>

            <div class="relative mt-[16px] flex gap-[8px]">
                <a href="{{ route('home') }}" target="_blank" class="flex h-[38px] flex-1 items-center justify-center gap-[6px] rounded-[10px] bg-white/10 text-[13px] font-semibold transition-colors hover:bg-white/20">
                    <x-ui-icon name="globe" class="size-[14px]" /> Site
                </a>
                <form action="{{ route('admin.logout') }}" method="post" class="flex-1">
                    @csrf
                    <button type="submit" class="flex h-[38px] w-full items-center justify-center gap-[6px] rounded-[10px] bg-editorial text-[13px] font-semibold transition-[transform,background-color] duration-300 hover:-translate-y-0.5">
                        <x-ui-icon name="lock" class="size-[14px]" /> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

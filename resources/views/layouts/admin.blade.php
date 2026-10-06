<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-admin>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Penida Gili</title>

    <script>document.documentElement.classList.add('js')</script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-admin-canvas">
    @include('partials.brand-intro')
    <div class="flex min-h-screen">
        @include('partials.admin.sidebar')

        <div class="min-w-0 flex-1 p-[12px] lg:p-[24px] lg:pl-0">
            <div class="pg-admin-panel min-h-full rounded-[24px] bg-surface px-[16px] pb-[40px] shadow-[0_10px_40px_-30px_rgba(6,30,56,0.4)] sm:px-[24px] lg:px-[40px]">
                <header class="sticky top-0 z-30 -mx-[16px] flex flex-wrap items-center justify-between gap-4 rounded-t-[24px] bg-surface/85 px-[16px] pb-[16px] pt-[20px] backdrop-blur-xl sm:-mx-[24px] sm:px-[24px] lg:-mx-[40px] lg:px-[40px] lg:pt-[32px]">
                    <div class="flex items-center gap-[12px]">
                        <button type="button" data-admin-open aria-label="Open menu"
                                class="grid size-[44px] place-items-center rounded-[14px] bg-admin-field text-admin-ink transition-colors hover:bg-editorial-rule lg:hidden">
                            <x-ui-icon name="sliders" class="size-[20px]" />
                        </button>
                        <div>
                            <p class="text-[18px] font-semibold leading-[1.4] text-admin-ink lg:text-[24px]">Hello, {{ auth()->user()?->name ?? 'Admin' }}</p>
                            <p class="text-[13px] leading-[1.5] text-admin-muted lg:text-[15px]">{{ now()->format('l, j F Y') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-[12px]">
                        <label class="relative hidden w-[360px] max-w-full md:block">
                            <span class="sr-only">Search</span>
                            <input type="search" placeholder="Search"
                                   class="h-[48px] w-full rounded-full bg-admin-field pl-[20px] pr-[48px] text-[15px] text-admin-ink placeholder:text-admin-nav transition-shadow focus:outline-none focus:ring-2 focus:ring-editorial/40">
                            <x-ui-icon name="search" class="pointer-events-none absolute right-[18px] top-1/2 size-[18px] -translate-y-1/2 text-admin-nav" />
                        </label>

                        <a href="{{ route('home') }}" target="_blank" aria-label="View site"
                           class="grid size-[48px] place-items-center rounded-full bg-admin-field text-admin-ink transition-[transform,background-color] duration-300 hover:-translate-y-0.5 hover:bg-editorial-rule">
                            <x-ui-icon name="globe" class="size-[19px]" />
                        </a>
                        <button type="button" aria-label="Notifications"
                                class="relative grid size-[48px] place-items-center rounded-full bg-admin-field text-admin-ink transition-colors duration-300 hover:bg-editorial-rule">
                            <x-ui-icon name="sparkles" class="size-[19px]" />
                            <span class="absolute right-[13px] top-[12px] size-[8px] animate-pulse rounded-full bg-[#e11d48]"></span>
                        </button>
                    </div>
                </header>

                <main class="pg-admin-main">
                    <x-admin.flash />
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const open = () => document.documentElement.classList.add('admin-nav-open');
            const close = () => document.documentElement.classList.remove('admin-nav-open');
            document.querySelectorAll('[data-admin-open]').forEach((b) => b.addEventListener('click', open));
            document.querySelectorAll('[data-admin-close],[data-admin-backdrop]').forEach((b) => b.addEventListener('click', close));
            document.addEventListener('keydown', (e) => e.key === 'Escape' && close());
        })();
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Penida Gili') — Penida Gili</title>
    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')">
    @endif
    @hasSection('meta-keywords')
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif

    {{-- Set before paint so the reveal styles never hide content for no-JS visitors. --}}
    <script>document.documentElement.classList.add('js')</script>

    {{-- Figma type: Manrope (marketing) + Plus Jakarta Sans (search bar / quotes) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('partials.brand-intro')
    @stack('site-nav')

    @include('partials.mobile-header')

    @yield('hero')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.mobile-tabbar')

    @include('partials.confirm-modal')

    @include('partials.lightbox')
    @if (($site['show_floating_whatsapp'] ?? '1') === '1')
        <a href="{{ \App\Models\Setting::whatsappUrl() }}" target="_blank" rel="noopener" aria-label="Chat on WhatsApp" data-testid="floating-whatsapp"
           class="pg-wa-float group fixed bottom-[96px] right-4 z-[45] flex items-center gap-2 rounded-full bg-brand p-3.5 text-white shadow-[0_16px_34px_-10px_rgba(50,138,211,0.8)] transition-[transform,background-color] duration-300 ease-smooth hover:-translate-y-1 hover:bg-[#2477bd] lg:bottom-8 lg:right-8 lg:p-5">
            <x-ui-icon name="whatsapp" class="size-6 lg:size-8" />
            <span class="hidden max-w-0 overflow-hidden whitespace-nowrap text-[18px] font-semibold transition-[max-width] duration-500 ease-smooth group-hover:max-w-[220px] lg:inline">Chat with us</span>
        </a>
    @endif
</body>
</html>

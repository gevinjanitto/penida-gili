{{-- Site footer (responsive): brand, links, destinations, newsletter and the MaiHarta credit with admin access. --}}
@php
    $footerLinks = [
        'Explore' => [
            'Fast Boat Schedules' => route('boats.schedules'),
            'Boats'               => route('boats.index'),
            'Activities'          => route('activities.index'),
            'Hotels'              => route('hotels.index'),
            'Travel Articles'     => route('articles.index'),
        ],
    ];
    $footerDestinations = \App\Models\Location::query()->active()->ordered()->take(4)->get();
    // Social links + WhatsApp come from Admin → Social & WhatsApp ($site is shared by AppServiceProvider).
    $socialLinks = collect([
        ['Instagram', 'instagram', $site['instagram'] ?? ''],
        ['Facebook', 'facebook', $site['facebook'] ?? ''],
        ['TikTok', 'tiktok', $site['tiktok'] ?? ''],
        ['YouTube', 'youtube', $site['youtube'] ?? ''],
        ['WhatsApp', 'whatsapp', ($site['show_whatsapp_social'] ?? '1') === '1' ? \App\Models\Setting::whatsappUrl() : ''],
        ['Email', 'mail', ($site['show_email_social'] ?? '1') === '1' && filled($site['email'] ?? '') ? 'mailto:'.$site['email'] : ''],
    ])->filter(fn ($link) => filled($link[2]));
@endphp

<footer class="relative isolate overflow-hidden bg-[#071a2e] pb-[92px] text-white lg:pb-0">
    {{-- soft glow accents --}}
    <div class="pointer-events-none absolute -left-40 -top-40 -z-10 size-[520px] rounded-full bg-brand/25 blur-[120px]"></div>
    <div class="pointer-events-none absolute -bottom-52 right-0 -z-10 size-[520px] rounded-full bg-sky-400/10 blur-[120px]"></div>

    {{-- CTA strip --}}
    <div class="container-page pt-[48px] lg:pt-[96px]">
        <div data-reveal class="flex flex-col gap-6 rounded-[26px] border border-white/10 bg-white/[0.04] p-6 backdrop-blur lg:flex-row lg:items-center lg:justify-between lg:rounded-[36px] lg:p-12">
            <div>
                <p class="text-[24px] font-bold leading-tight tracking-tight lg:text-[44px]">Ready to cross to paradise?</p>
                <p class="mt-2 text-[14px] text-white/60 lg:text-[18px]">Compare every fast boat sailing and lock in your seat in minutes.</p>
            </div>
            <a href="{{ route('boats.schedules') }}"
               class="pg-shine inline-flex w-fit items-center gap-3 rounded-full bg-brand px-6 py-3.5 text-[15px] font-semibold transition-[transform,background-color] duration-300 ease-smooth hover:-translate-y-1 hover:bg-[#2477bd] lg:px-10 lg:py-5 lg:text-[19px]">
                <x-ui-icon name="ship" class="size-5 lg:size-6" /> Find a fast boat
            </a>
        </div>
    </div>

    <div class="container-page grid gap-10 py-[48px] sm:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1.4fr] lg:gap-16 lg:py-[90px]">
        {{-- Brand --}}
        <div data-reveal>
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="" class="h-[34px] w-[68px] lg:h-[56px] lg:w-[112px]">
                <img src="{{ asset('images/logo/logo-word-light.svg') }}" alt="Penida Gili" class="h-[34px] w-[150px] lg:h-[56px] lg:w-[250px]">
            </a>
            <p class="mt-5 max-w-[380px] text-[14px] leading-[1.8] text-white/60 lg:text-[17px]">
                Penida Gili is your premier boat booking partner — fast boats, private charters and island activities across Bali, Nusa Penida, Lembongan and the Gilis.
            </p>
            <ul class="mt-6 flex flex-wrap items-center gap-3" data-testid="footer-socials">
                @foreach ($socialLinks as [$name, $icon, $href])
                    <li>
                        <a href="{{ $href }}" aria-label="{{ $name }}" @if (str_starts_with($href, 'http')) target="_blank" rel="noopener" @endif
                           class="grid size-10 place-items-center rounded-full border border-white/15 text-white/80 transition-[transform,background-color,border-color,color] duration-300 ease-smooth hover:-translate-y-1 hover:border-brand hover:bg-brand hover:text-white lg:size-12">
                            <x-ui-icon :name="$icon" class="size-4 lg:size-5" />
                        </a>
                    </li>
                @endforeach
            </ul>
            @if (filled($site['phone'] ?? '') || filled($site['address'] ?? ''))
                <ul class="mt-5 flex flex-col gap-2 text-[14px] text-white/60 lg:text-[16px]">
                    @if (filled($site['phone'] ?? ''))
                        <li class="flex items-center gap-2"><x-ui-icon name="phone" class="size-4 text-sky-300" /> {{ $site['phone'] }}</li>
                    @endif
                    @if (filled($site['address'] ?? ''))
                        <li class="flex items-center gap-2"><x-ui-icon name="pin" class="size-4 text-sky-300" /> {{ $site['address'] }}</li>
                    @endif
                </ul>
            @endif
        </div>

        {{-- Links --}}
        @foreach ($footerLinks as $heading => $links)
            <div data-reveal style="--reveal-delay: 80ms">
                <h2 class="text-[13px] font-semibold uppercase tracking-[0.16em] text-white/40 lg:text-[15px]">{{ $heading }}</h2>
                <ul class="mt-4 flex flex-col gap-2.5 lg:mt-6 lg:gap-4">
                    @foreach ($links as $label => $href)
                        <li>
                            <a href="{{ $href }}" class="group inline-flex items-center gap-2 text-[15px] text-white/75 transition-colors duration-300 hover:text-white lg:text-[17px]">
                                <span class="h-px w-0 bg-sky-300 transition-[width] duration-300 ease-smooth group-hover:w-4"></span>{{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        {{-- Destinations --}}
        <div data-reveal style="--reveal-delay: 140ms">
            <h2 class="text-[13px] font-semibold uppercase tracking-[0.16em] text-white/40 lg:text-[15px]">Destinations</h2>
            <ul class="mt-4 flex flex-col gap-2.5 lg:mt-6 lg:gap-4">
                @foreach ($footerDestinations as $location)
                    <li>
                        <a href="{{ route('activities.index', ['location' => $location->slug]) }}" class="group inline-flex items-center gap-2 text-[15px] text-white/75 transition-colors duration-300 hover:text-white lg:text-[17px]">
                            <span class="h-px w-0 bg-sky-300 transition-[width] duration-300 ease-smooth group-hover:w-4"></span>{{ $location->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Newsletter --}}
        <div data-reveal style="--reveal-delay: 200ms">
            <h2 class="text-[13px] font-semibold uppercase tracking-[0.16em] text-white/40 lg:text-[15px]">Join a Newsletter</h2>
            <p class="mt-4 text-[14px] leading-[1.7] text-white/60 lg:mt-6 lg:text-[17px]">Island tips, new routes and seasonal deals — once a month.</p>
            <form action="{{ route('newsletter.store') }}" method="post" data-confirm="newsletter" class="mt-4 lg:mt-6">
                @csrf
                <input type="hidden" name="source" value="footer">
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden" aria-hidden="true">
                <div class="flex items-center gap-2 rounded-full border border-white/15 bg-white/5 p-1.5 transition-colors focus-within:border-brand">
                    <input name="email" type="email" required value="{{ old('email') }}" placeholder="Your email" aria-label="Your email"
                           class="min-w-0 flex-1 bg-transparent px-4 text-[14px] text-white placeholder:text-white/40 focus:outline-none lg:text-[16px]">
                    <button type="submit" class="shrink-0 rounded-full bg-brand px-5 py-2.5 text-[14px] font-semibold transition-[transform,background-color] duration-300 hover:bg-[#2477bd] active:scale-95 lg:px-7 lg:py-3.5 lg:text-[16px]">Submit</button>
                </div>
                @if (session('newsletter'))
                    <p class="mt-3 text-[13px] text-emerald-300">{{ session('newsletter') }}</p>
                @endif
                @error('email')
                    <p class="mt-3 text-[13px] text-rose-300">{{ $message }}</p>
                @enderror
            </form>
        </div>
    </div>

    {{-- Credit bar --}}
    <div class="border-t border-white/10">
        <div class="container-page flex flex-col items-center justify-center gap-2 py-5 text-center text-[13px] text-white/55 sm:flex-row sm:gap-4 lg:py-7 lg:text-[16px]">
            <p>
                &copy; Copyright Penida Gili 2026 | Design &amp; Develop
                <a href="https://www.maiharta.com" target="_blank" rel="noopener" class="font-semibold text-white underline-offset-4 transition-colors hover:text-sky-300 hover:underline">MaiHarta</a>
            </p>
            <span class="hidden h-4 w-px bg-white/20 sm:block"></span>
            <a href="{{ route('admin.dashboard') }}" data-testid="footer-admin-link"
               class="inline-flex items-center gap-1.5 rounded-full border border-white/15 px-3 py-1 text-white/70 transition-[background-color,color,border-color] duration-300 hover:border-brand hover:bg-brand hover:text-white lg:px-4 lg:py-1.5">
                <x-ui-icon name="lock" class="size-3.5 lg:size-4" /> Admin
            </a>
        </div>
    </div>
</footer>

{{-- Admin sign-in: inset island photo on the left, a calm credentials column on the right. --}}
<!DOCTYPE html>
{{-- data-no-zoom: this page is authored at real browser size, not the 1920px marketing grid. --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-no-zoom class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In — Penida Gili Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full min-h-screen bg-[#f5f8fb] font-jakarta text-[#181c1e]">
    @include('partials.brand-intro')

    @php
        $field = 'peer w-full rounded-[12px] border bg-white py-[13px] pl-[46px] pr-[16px] text-[15px] leading-[22px] text-[#181c1e] placeholder:text-[#9aa3ad]'
            .' shadow-[0_1px_2px_rgba(16,24,40,0.04)] transition-[border-color,box-shadow] duration-200'
            .' focus:border-brand focus:outline-none focus:ring-4 focus:ring-brand/15';
        $fieldState = $errors->has('email') ? ' border-[#f87171]' : ' border-[#dde3e9] hover:border-[#c3ccd5]';
        $iconClass = 'pointer-events-none absolute left-[16px] top-1/2 size-[18px] -translate-y-1/2 text-[#9aa3ad] transition-colors duration-200 peer-focus:text-brand';
    @endphp

    <main class="grid min-h-screen lg:grid-cols-[minmax(0,1.15fr)_minmax(0,1fr)]">
        {{-- Photo panel (desktop) --}}
        <section class="relative hidden p-[16px] lg:block" aria-hidden="true">
            <div class="pg-login-photo relative h-full min-h-[640px] overflow-hidden rounded-[28px]">
                {{-- Swap this file to change the panel photo; it is cropped to fill the panel. --}}
                <img src="{{ asset('images/admin/login-kelingking.jpg') }}" alt=""
                     class="absolute inset-0 size-full object-cover object-center">
                <div class="absolute inset-0 bg-gradient-to-t from-[rgba(6,33,58,0.82)] via-[rgba(6,33,58,0.15)] to-[rgba(6,33,58,0.35)]"></div>

                <div class="relative flex h-full flex-col justify-between p-[44px] text-white">
                    <a href="{{ route('home') }}" class="flex w-fit items-center gap-[10px]">
                        <img src="{{ asset('images/logo/logo-mark-light.svg') }}" alt="" class="h-[34px] w-[64px]">
                        <img src="{{ asset('images/logo/logo-word-light.svg') }}" alt="Penida Gili" class="h-[30px] w-[132px]">
                    </a>

                    <div class="max-w-[540px]">
                        <span data-testid="login-badge"
                              class="inline-flex items-center gap-[8px] rounded-full border border-white/25 bg-white/15 px-[14px] py-[6px] text-[13px] font-semibold leading-[20px] backdrop-blur-md">
                            <span class="size-[7px] rounded-full bg-[#7cd8da] shadow-[0_0_0_4px_rgba(124,216,218,0.25)]"></span>
                            Penida Gili Admin
                        </span>

                        <h1 class="mt-[20px] font-sans text-[44px] font-bold leading-[52px] tracking-[-0.8px]">
                            Every crossing, stay and story — in one place.
                        </h1>
                        <p class="mt-[14px] max-w-[460px] text-[16px] leading-[26px] text-white/80">
                            Manage boats, schedules, hotels, activities and articles for Bali, Nusa Penida, Lembongan and the Gili Islands.
                        </p>

                        <ul class="mt-[28px] flex flex-wrap gap-[10px] text-[13px] font-semibold">
                            @foreach (['Boats & Schedules', 'Hotels', 'Activities', 'Articles', 'Bookings'] as $item)
                                <li class="rounded-full border border-white/20 bg-white/10 px-[14px] py-[7px] backdrop-blur-md">{{ $item }}</li>
                            @endforeach
                        </ul>

                        <p class="mt-[36px] flex items-center gap-[8px] text-[12px] uppercase tracking-[0.18em] text-white/60">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-[14px]"><path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.5"/></svg>
                            Kelingking, Nusa Penida
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Credentials --}}
        <section class="relative flex flex-col px-[24px] py-[32px] sm:px-[48px] lg:px-[64px]">
            {{-- Mobile: a slim photo banner keeps the island mood. --}}
            <div class="relative -mx-[24px] -mt-[32px] mb-[28px] h-[190px] overflow-hidden sm:-mx-[48px] lg:hidden">
                <img src="{{ asset('images/admin/login-kelingking.jpg') }}" alt="" class="absolute inset-0 size-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-[rgba(6,33,58,0.25)] to-[rgba(6,33,58,0.7)]"></div>
                <span class="absolute bottom-[18px] left-[24px] inline-flex items-center gap-[8px] rounded-full border border-white/25 bg-white/15 px-[12px] py-[5px] text-[12px] font-semibold text-white backdrop-blur-md sm:left-[48px]">
                    <span class="size-[6px] rounded-full bg-[#7cd8da]"></span>
                    Penida Gili Admin
                </span>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('home') }}" class="group flex items-center gap-[6px] text-[13px] font-semibold text-[#717782] transition-colors hover:text-brand">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-[15px] transition-transform duration-300 group-hover:-translate-x-0.5"><path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Back to website
                </a>
            </div>

            <div class="flex flex-1 items-center justify-center py-[40px]">
                <div class="pg-login-card w-full max-w-[400px]">
                    <a href="{{ route('home') }}" class="mb-[28px] flex w-fit items-center gap-[8px]" data-testid="login-logo">
                        <img src="{{ asset('images/logo/logo-mark-dark.svg') }}" alt="" class="h-[36px] w-[70px]">
                        <img src="{{ asset('images/logo/logo-word-dark.svg') }}" alt="Penida Gili" class="h-[31px] w-[140px]">
                    </a>

                    <h2 class="font-sans text-[32px] font-bold leading-[40px] tracking-[-0.6px]">Welcome back</h2>
                    <p class="mt-[8px] text-[15px] leading-[24px] text-[#717782]">Sign in to the Penida Gili admin console.</p>

                    <form action="{{ route('admin.login') }}" method="post" class="mt-[32px] flex flex-col gap-[18px]" data-testid="admin-login-form">
                        @csrf

                        <label class="flex flex-col gap-[8px]">
                            <span class="text-[13px] font-semibold leading-[18px] text-[#414751]">Email</span>
                            <span class="relative block">
                                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                       placeholder="you@penidagili.com" class="{{ $field.$fieldState }}" data-testid="login-email">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="{{ $iconClass }}" aria-hidden="true">
                                    <rect x="3" y="5" width="18" height="14" rx="2.5"/><path d="m4 7 8 6 8-6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </label>

                        <label class="flex flex-col gap-[8px]">
                            <span class="text-[13px] font-semibold leading-[18px] text-[#414751]">Password</span>
                            {{-- data-password-field: the eye button toggles the input type (resources/js/admin-login.js). --}}
                            <span class="relative block" data-password-field>
                                <input type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"
                                       class="{{ $field.$fieldState }} pr-[48px]" data-testid="login-password">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="{{ $iconClass }}" aria-hidden="true">
                                    <rect x="4.5" y="10.5" width="15" height="10" rx="2.5"/><path d="M8 10.5V7.5a4 4 0 0 1 8 0v3" stroke-linecap="round"/>
                                </svg>
                                <button type="button" data-password-toggle aria-label="Show password"
                                        class="absolute right-[10px] top-1/2 flex size-[32px] -translate-y-1/2 items-center justify-center rounded-[8px] text-[#9aa3ad] transition-colors hover:bg-[#f1f4f6] hover:text-[#414751]">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-[18px]" aria-hidden="true">
                                        <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" stroke-linecap="round" stroke-linejoin="round"/>
                                        <circle cx="12" cy="12" r="3.2"/>
                                    </svg>
                                </button>
                            </span>
                        </label>

                        @error('email')
                            <p role="alert" class="flex items-start gap-[8px] rounded-[10px] border border-[#fecaca] bg-[#fef2f2] px-[14px] py-[10px] text-[13px] leading-[19px] text-[#b91c1c]">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mt-px size-[16px] shrink-0"><circle cx="12" cy="12" r="9"/><path d="M12 8v4.5M12 16h.01" stroke-linecap="round"/></svg>
                                {{ $message }}
                            </p>
                        @enderror

                        <label class="flex cursor-pointer items-center gap-[10px] text-[14px] leading-[20px] text-[#414751]">
                            <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                                   class="size-[16px] shrink-0 rounded-[4px] accent-[#328ad3]">
                            Keep me signed in
                        </label>

                        <button type="submit" data-testid="login-submit"
                                class="group mt-[6px] flex w-full items-center justify-center gap-[8px] rounded-[12px] bg-brand py-[14px] text-[15px] font-semibold leading-[22px] text-white
                                       shadow-[0_14px_28px_-14px_rgba(50,138,211,0.9)] transition-[background-color,transform,box-shadow] duration-300 ease-smooth
                                       hover:-translate-y-0.5 hover:bg-[#2477bd] hover:shadow-[0_18px_32px_-14px_rgba(50,138,211,0.95)] active:translate-y-0">
                            Sign In
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="size-[17px] transition-transform duration-300 group-hover:translate-x-1" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </form>

                    <p class="mt-[28px] flex items-center gap-[8px] text-[13px] leading-[20px] text-[#9aa3ad]">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="size-[15px] shrink-0"><path d="M12 3 5 6v5.5c0 4.3 3 8.2 7 9.5 4-1.3 7-5.2 7-9.5V6l-7-3Z" stroke-linejoin="round"/></svg>
                        Secure area for Penida Gili staff only.
                    </p>
                </div>
            </div>

            <p class="text-center text-[12px] text-[#9aa3ad] lg:text-left">&copy; {{ now()->year }} Penida Gili &middot; The Island Fast Cruise</p>
        </section>
    </main>
</body>
</html>

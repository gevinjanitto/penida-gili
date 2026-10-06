{{-- Site settings: social media + WhatsApp + contact --}}
@extends('layouts.admin')

@section('title', 'Settings')

@section('admin-active', 'settings')

@php
    $groups = [
        'contact' => ['WhatsApp & Contact', 'Number and message used by every WhatsApp button, plus the contact details on the site', 'whatsapp'],
        'social'  => ['Social Media', 'Links shown as icons in the website footer — leave a field empty to hide that icon', 'instagram'],
    ];
    $input = 'w-full rounded-[10px] border border-[rgba(192,199,211,0.6)] bg-[#f7fafc] px-[14px] py-[11px] font-jakarta text-[15px] text-editorial-ink placeholder:text-editorial-meta transition-shadow focus:outline-none focus:ring-2 focus:ring-editorial/40';
@endphp

@section('content')
    <x-admin.form-page heading="Site Settings" subtitle="Manage social media links and the WhatsApp number used across the website." :back-href="route('admin.dashboard')">
        <form action="{{ route('admin.settings.update') }}" method="post" class="grid [&>*]:min-w-0 gap-[24px] xl:grid-cols-[minmax(0,1fr)_380px]">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-[24px]">
                @foreach ($groups as $group => [$title, $description, $icon])
                    <section data-reveal class="rounded-[20px] border border-[rgba(192,199,211,0.4)] bg-surface p-[20px] shadow-[0_10px_30px_-24px_rgba(6,30,56,0.4)] lg:p-[28px]">
                        <div class="flex items-start gap-[14px]">
                            <span class="grid size-[44px] shrink-0 place-items-center rounded-[14px] bg-[#e0f2fe] text-editorial"><x-ui-icon :name="$icon" class="size-[20px]" /></span>
                            <div>
                                <h2 class="text-[19px] font-bold text-editorial-ink">{{ $title }}</h2>
                                <p class="font-jakarta text-[14px] text-editorial-body">{{ $description }}</p>
                            </div>
                        </div>

                        <div class="mt-[22px] grid [&>*]:min-w-0 gap-[18px] md:grid-cols-2">
                            @foreach ($definitions as $key => $def)
                                @continue($def['group'] !== $group)
                                @if ($def['type'] === 'toggle')
                                    <label class="pg-check-card md:col-span-1">
                                        <input type="checkbox" name="{{ $key }}" value="1" @checked(old($key, $values[$key]) === '1') class="peer sr-only">
                                        <span class="pg-check-box"><x-ui-icon name="check" class="size-[12px]" stroke="3" /></span>
                                        <span class="text-[14px] font-semibold text-editorial-ink">{{ $def['label'] }}</span>
                                    </label>
                                @else
                                    <div @class(['flex flex-col gap-[8px]', 'md:col-span-2' => in_array($key, ['whatsapp_message', 'address'])])>
                                        <label for="set-{{ $key }}" class="font-jakarta text-[13px] font-semibold uppercase tracking-[0.08em] text-editorial-body">{{ $def['label'] }}</label>
                                        <input id="set-{{ $key }}" name="{{ $key }}" type="{{ $def['type'] === 'tel' ? 'text' : $def['type'] }}" value="{{ old($key, $values[$key]) }}"
                                               placeholder="{{ $def['placeholder'] ?? '' }}" class="{{ $input }}" data-setting="{{ $key }}">
                                        @if (! empty($def['help']))
                                            <span class="font-jakarta text-[12px] text-editorial-meta">{{ $def['help'] }}</span>
                                        @endif
                                        @error($key) <span class="font-jakarta text-[13px] text-[#dc2626]">{{ $message }}</span> @enderror
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>

            {{-- Live preview --}}
            <aside class="flex flex-col gap-[20px]">
                <div data-reveal style="--reveal-delay: 120ms" class="sticky top-[110px] overflow-hidden rounded-[20px] bg-[#071a2e] p-[24px] text-white">
                    <p class="text-[12px] font-semibold uppercase tracking-[0.16em] text-white/50">Footer preview</p>
                    <ul class="mt-[16px] flex flex-wrap gap-[10px]">
                        @foreach (['instagram' => 'instagram', 'facebook' => 'facebook', 'tiktok' => 'tiktok', 'youtube' => 'youtube'] as $key => $icon)
                            <li @class(['grid size-[44px] place-items-center rounded-full border border-white/15 transition-opacity', 'opacity-25' => blank($values[$key])])><x-ui-icon :name="$icon" class="size-[18px]" /></li>
                        @endforeach
                        <li class="grid size-[44px] place-items-center rounded-full border border-white/15"><x-ui-icon name="whatsapp" class="size-[18px]" /></li>
                        <li class="grid size-[44px] place-items-center rounded-full border border-white/15"><x-ui-icon name="mail" class="size-[18px]" /></li>
                    </ul>
                    <a href="{{ \App\Models\Setting::whatsappUrl() }}" target="_blank" rel="noopener"
                       class="mt-[20px] flex items-center justify-center gap-[8px] rounded-[12px] bg-white py-[12px] text-[15px] font-semibold text-[#071a2e] transition-transform hover:-translate-y-0.5">
                        <x-ui-icon name="whatsapp" class="size-[18px]" /> Test WhatsApp link
                    </a>
                    <p class="mt-[10px] break-all font-jakarta text-[12px] text-white/50">{{ \App\Models\Setting::whatsappUrl() }}</p>
                </div>

                <button type="submit" class="pg-shine flex h-[52px] items-center justify-center gap-[8px] rounded-[12px] bg-editorial text-[16px] font-semibold text-white transition-transform duration-300 hover:-translate-y-0.5">
                    <x-ui-icon name="check" class="size-[18px]" /> Save Settings
                </button>
            </aside>
        </form>
    </x-admin.form-page>
@endsection

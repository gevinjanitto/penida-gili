{{-- "Where To?" destinations — master locations managed in the console. Responsive (mobile + desktop). --}}
<section class="relative overflow-hidden bg-white py-[64px] lg:py-[120px]">
    <div class="container-page">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p data-reveal class="inline-flex items-center gap-2 text-[13px] font-semibold uppercase tracking-[0.16em] text-brand lg:text-[16px]">
                    <x-ui-icon name="compass" class="size-4 lg:size-5" /> Where To?
                </p>
                <h2 data-reveal="blur" style="--reveal-delay: 80ms" class="mt-2 text-[30px] font-bold leading-[1.15] tracking-[-0.02em] text-[#0b2540] lg:mt-4 lg:text-[56px]">
                    Pick your island, <span class="text-brand">we plan the fun</span>
                </h2>
            </div>
            <p data-reveal style="--reveal-delay: 160ms" class="max-w-[520px] text-[15px] leading-[1.7] text-slate-500 lg:text-[18px]">
                From manta rays in Nusa Penida to turtles in Gili Trawangan — choose a destination and discover the activities waiting there.
            </p>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:mt-[60px] lg:grid-cols-4 lg:grid-rows-2 lg:gap-6">
            @foreach ($destinations as $index => $location)
                <a href="{{ route('activities.index', ['location' => $location->slug]) }}"
                   data-reveal="zoom" style="--reveal-delay: {{ $index * 90 }}ms"
                   @class([
                       'group relative isolate flex min-h-[260px] flex-col justify-end overflow-hidden rounded-[26px] p-5 text-white lg:rounded-[34px] lg:p-8',
                       'lg:col-span-2 lg:row-span-2 lg:min-h-[640px]' => $index === 0,
                       'lg:col-span-2 lg:min-h-[308px]' => $index === 1,
                       'lg:min-h-[308px]' => $index > 1,
                   ])>
                    <img src="{{ $location->image_url }}" alt="{{ $location->name }}" loading="lazy" class="pg-zoom absolute inset-0 -z-10 size-full object-cover">
                    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-[#06213a]/85 via-[#06213a]/25 to-transparent transition-opacity duration-500 group-hover:opacity-90"></div>

                    <span class="absolute right-4 top-4 grid size-11 place-items-center rounded-full bg-white/20 backdrop-blur-md transition-[transform,background-color,color] duration-500 ease-smooth group-hover:rotate-45 group-hover:bg-white group-hover:text-[#0b2540] lg:right-6 lg:top-6 lg:size-14">
                        <x-ui-icon name="arrow-up-right" class="size-5 lg:size-6" />
                    </span>

                    <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-[12px] font-semibold backdrop-blur lg:text-[14px]">
                        <x-ui-icon name="sparkles" class="size-3.5" /> {{ $location->activities_count }} {{ str('activity')->plural($location->activities_count) }}
                    </span>
                    <h3 @class(['mt-3 font-bold tracking-tight', 'text-[28px] lg:text-[52px]' => $index === 0, 'text-[24px] lg:text-[32px]' => $index > 0])>{{ $location->name }}</h3>
                    <p class="mt-1 text-[14px] text-white/80 lg:text-[17px]">{{ $location->tagline }}</p>
                    @if ($index === 0 && $location->description)
                        <p class="mt-3 hidden max-w-[520px] text-[17px] leading-[1.7] text-white/75 lg:block">{{ $location->description }}</p>
                    @endif
                    <span class="mt-4 h-[2px] w-12 origin-left rounded-full bg-sky-300 transition-transform duration-700 ease-smooth group-hover:scale-x-[3]"></span>
                </a>
            @endforeach
        </div>
    </div>
</section>

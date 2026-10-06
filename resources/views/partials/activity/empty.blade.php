<div data-reveal="zoom" class="flex w-full flex-col items-center rounded-[28px] border border-dashed border-slate-200 bg-white px-6 py-14 text-center lg:py-24">
    <span class="grid size-16 place-items-center rounded-full bg-sky-50 text-brand lg:size-24"><x-ui-icon name="compass" class="pg-float size-8 lg:size-12" /></span>
    <p class="mt-5 text-[18px] font-bold text-slate-900 lg:text-[28px]">No activities here yet</p>
    <p class="mt-2 max-w-[460px] text-[14px] text-slate-500 lg:text-[18px]">We are curating experiences for this destination. Browse the other islands in the meantime.</p>
    <a href="{{ route('activities.index') }}" class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand px-6 py-3 text-[15px] font-semibold text-white transition-transform hover:-translate-y-0.5 lg:px-8 lg:py-4 lg:text-[18px]">
        See all activities <x-ui-icon name="arrow-right" class="size-4" />
    </a>
</div>

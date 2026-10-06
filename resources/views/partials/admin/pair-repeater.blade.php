{{-- Generic repeating rows for the console forms (hotel highlights, policies, nearby places).
     Posts as {name}[i][{field}]; blank rows are ignored on save and "Remove" drops a row.
     $fields: list of [key, label, type (text|textarea), placeholder]. --}}
@php
    $hint ??= null;
    $testid ??= null;
    $rows = old($name, $rows ?? []) ?: [];
    $grid = count($fields) > 1 && collect($fields)->every(fn ($f) => $f[2] === 'text') ? 'sm:grid-cols-2' : '';
@endphp

<div data-repeater @if ($testid) data-testid="{{ $testid }}" @endif>
    @if ($hint)
        <p class="mb-[14px] font-jakarta text-[14px] leading-[22px] text-editorial-body">{{ $hint }}</p>
    @endif

    <div class="flex flex-col gap-[12px]" data-repeater-list>
        @foreach ($rows as $i => $row)
            @include('partials.admin.pair-repeater-row', ['i' => $i, 'row' => $row])
        @endforeach
    </div>

    <p class="mt-[12px] font-jakarta text-[14px] leading-[22px] text-editorial-meta" data-repeater-empty @if ($rows) hidden @endif>{{ $empty }}</p>

    <button type="button" data-repeater-add
            class="mt-[14px] rounded-[8px] border border-[rgba(192,199,211,0.6)] bg-[#f7fafc] px-[16px] py-[10px] font-jakarta text-[14px] font-semibold text-brand
                   transition-colors duration-300 hover:border-brand hover:bg-brand/5">
        {{ $add }}
    </button>

    <template data-repeater-template>
        @include('partials.admin.pair-repeater-row', ['i' => '__INDEX__', 'row' => []])
    </template>
</div>

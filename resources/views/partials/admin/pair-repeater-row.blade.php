{{-- One row of partials.admin.pair-repeater. --}}
<div class="rounded-admin border border-[rgba(192,199,211,0.5)] bg-[#f7fafc] p-[16px]" data-repeater-row>
    <div class="grid gap-[12px] {{ $grid }}">
        @foreach ($fields as [$key, $fieldLabel, $type, $placeholder])
            <x-admin.field :label="$fieldLabel" name="{{ $name }}[{{ $i }}][{{ $key }}]" :type="$type" :value="$row[$key] ?? null" :placeholder="$placeholder" />
        @endforeach
    </div>

    <button type="button" data-repeater-drop class="mt-[10px] font-jakarta text-[13px] font-semibold text-[#b91c1c] hover:underline">Remove</button>
</div>

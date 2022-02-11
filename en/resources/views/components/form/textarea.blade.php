<div class="flex flex-col">
    <div class="flex flex-col">
        <div class="font-light">{{ $label }}</div>
        <div class="mt-3">
            <textarea {{ $attributes->class(['format_text_area']) }}>{{ $texto }}</textarea>
        </div>
    </div>
    @error($error)
        <div class="seccion-requiere-validacion">
            <span class="text-xs text-pink-600">
                {{ $message }}
            </span>
        </div>
    @enderror
</div>

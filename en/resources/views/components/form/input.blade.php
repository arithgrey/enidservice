<div class="flex flex-col">
    <div class="flex items-center border-b border-sky-600 py-2">
      <div class="font-semibold w-1/4">{{$label}}</div>
      <div class="w-3/4">
        <input {{ $attributes->class(['format_input']) }}/>
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

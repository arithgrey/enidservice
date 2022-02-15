<template>
  <div>
    @error($error)
    <div class="seccion-requiere-validacion">
      <span class="text-xs text-pink-600">
        {{ $message }}
      </span>
    </div>
    @enderror
  </div>
</template>

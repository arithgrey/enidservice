<template>
  <div class="flex flex-col">
    <div class="flex items-center justify-between border-b border-sky-600 py-2">
      <div class="font-light mr-3">{{ $label }}</div>
      <div><input {{ $attributes- />class(['format_input']) }}/></div>
    </div>
    <x-form.alerta error="{{$error}}" />
  </div>
</template>

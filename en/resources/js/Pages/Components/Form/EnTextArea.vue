<template>
  <div class="flex flex-col">
    <div class="flex flex-col">
      <div class="font-light">
        <slot name="label" />
      </div>
      <div class="mt-3">
        <slot name="area" />
      </div>
      <div>
        <slot name="errores" />
      </div>
    </div>
  </div>
</template>
<script>
import { defineComponent } from "vue";
export default defineComponent({
  components: {},
  props: ["input"],
});
</script>

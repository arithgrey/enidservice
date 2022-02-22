<template>
  <div class="flex flex-col">
    <div class="flex items-center justify-between border-b border-sky-600 py-2">
      <div class="">
        <label class="font-light mr-3">
          <slot name="label" />
        </label>
      </div>
      <div class="w-3/4">
        <!--Input-->
        <slot name="input" />
      </div>
    </div>
    <div>
        <slot name="errores"/>

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

<template>
  <div class="flex flex-col">
    <div class="flex flex-col">
      <div class="font-light">{{ input.texto_label }}</div>
      <div class="mt-3">
        <textarea
          class="format_text_area w-full"
          v-bind:id="input.id"
          v-bind:class="input.class"
          v-bind:name="input.name"
          v-bind:placeholder="input.placeholder"
          >{{ input.old }}</textarea>
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

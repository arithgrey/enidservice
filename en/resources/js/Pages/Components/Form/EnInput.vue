<template>
  <div class="flex flex-col">
    <div class="flex items-center justify-between border-b border-sky-600 py-2">
      <div class="font-light mr-3">{{ input.texto_label }}</div>
      <div>
        <input
          class="format_input"
          v-bind:class="input.class"
          v-bind:type="input.type"
          v-bind:name="input.name"
          v-bind:placeholder="input.placeholder"
          v-bind:value="input.value"
        />
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

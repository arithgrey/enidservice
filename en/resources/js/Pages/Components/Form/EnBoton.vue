<template>
  <button class="format_submit w-full">
    <slot />
  </button>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  name: "EnBoton",
  components: {},
  data() {
    return {

    };
  },
  props: { },
  methods: {},
});
</script>

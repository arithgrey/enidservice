<template>
  <button class="format_submit w-full" type="submit" v-bind:class="atributos.class">
    <slot/>
  </button>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  components: {},
  props: ["atributos"],
});
</script>

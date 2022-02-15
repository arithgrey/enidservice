<template>
  <button class="format_submit w-full" type="submit" v-bind:class="atributos.class">
    {{ atributos.titulo ?? "Enviar" }}
  </button>
</template>

<script>
import { defineComponent } from "vue";
export default defineComponent({
  components: {},
  props: ["atributos"],
});
</script>

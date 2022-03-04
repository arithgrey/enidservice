<template>
  <div
    v-if="valoracion.recomendaria"
    class="flex justify-end text-indigo-600 hover:text-indigo-900 font-medium"
  >
    <div>Nos recomendaria!</div>
    <div class="">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </div>
  </div>

  <div v-else class="text-pink-600 hover:text-pink-900 font-medium">
    No le agradó nuestro servicio :(
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  components: {},
  props: {
    valoracion: Object,
  },
});
</script>

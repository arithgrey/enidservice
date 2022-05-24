<template>
  <div class="py-10">
    <div v-if="orden_comentarios.data" class="mx-auto">
      <p class="font-bold">
        Conversasiónes donde se ha mencionado a este contacto
      </p>
    </div>

    <div
      class="border-b-2 border-blue-600 cursor-pointer grid grid-cols-2"
      v-for="orden_comentario in orden_comentarios.data"
    >
      <div>
        <a
          class="text-sky-700"
          :href="orden_comentario.path_orden"
          target="_blank"
        >
          Orden compra
        </a>
      </div>
      <div>{{ orden_comentario.comentario }}</div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  components: {},
  props: {},
  data() {
    return {
      orden_comentarios: Object,
    };
  },
  methods: {
    busqueda: function (q) {
      return axios.get("api/v1/orden-comentario/?q=" + q).then((response) => {
        this.orden_comentarios = response.data;
      });
    },
  },
});
</script>

<template>
  <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div v-if="orden_comentarios.data" class="w-2/3 mx-auto mt-5">
      <p class="font-bold">
        Conversasiónes donde se ha mencionado a este contacto
      </p>
    </div>
    <table class="w-2/3 mx-auto mt-5">
      <tbody>
        <tr
          class="border-b-2 border-blue-600 cursor-pointer"
          v-for="orden_comentario in orden_comentarios.data"
        >
          <td>
            <a
              class="text-sky-700"
              :href="orden_comentario.path_orden"
              target="_blank"
            >
              Orden compra
            </a>
          </td>
          <td>{{ orden_comentario.comentario }}</td>
        </tr>
      </tbody>
    </table>

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

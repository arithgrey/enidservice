<template>
  <Head title="Enid service" />
  <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <h1>Pedidos por alcaldia</h1>
    <form @submit.prevent="busqueda">
      <div class="flex justify-center">
        <div class="flex mr-2">
          <div class="mr-2">Fecha inicio</div>
          <input type="date" v-model="date" />
        </div>
        <div class="flex mr-3">
          <div class="mr-2">Fecha término</div>
          <input type="date" v-model="enddate" />
        </div>
        <div>
          <en-boton> Buscar </en-boton>
        </div>
      </div>
    </form>
  </div>
  <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <table class="w-2/3 mx-auto mt-5">
      <thead>
        <th class="text-left">Alcaldia</th>
        <th>Número de pedidos</th>
      </thead>
      <tbody class="mt-5">
        <tr
          class="border-b-2 border-blue-600 cursor-pointer"
          v-for="lista in indicadores"

        >
          <td>
            {{ lista.delegacion }}
          </td>
          <td class="text-center">
            {{ lista.total }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({

  components: {},
  props: {
    indicadores: Object,
  },
  data() {
    return {
      q: "",
      date: new Date(),
      enddate: new Date(),
    };
  },
  watch: {

  },
  methods: {
    busqueda() {
      let params = { fecha_inicio: this.date, fecha_termino: this.enddate };
      this.$inertia.replace(
        this.route("indicadores-ubicaciones.index", params)
      );



    },
  },

});
</script>


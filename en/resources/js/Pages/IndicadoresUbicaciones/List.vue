<template>
  <div class="w-11/12 mx-auto">
    <div class="grid grid-cols-1">
      <form @submit.prevent="busqueda">
        <div class="flex justify-center mt-5">
          <div class="flex justify-items-center items-center mr-4">
            <div class="mr-2 font-semibold">Inicio</div>
            <input type="date" v-model="date" />
          </div>
          <div class="flex justify-items-center items-center mr-4">
            <div class="mr-2 font-semibold">Término</div>
            <input type="date" v-model="enddate" />
          </div>
          <div class="self-center">
            <en-boton> Buscar </en-boton>
          </div>
        </div>
      </form>
    </div>

    <div class="grid grid-cols-1 mt-5">
      <div class="grid grid-cols-2 mb-5">
        <div class="font-bold">Alcaldia</div>
        <div class="font-bold text-center">#pedidos</div>
      </div>
      <div
        class="border border-blue-600 grid grid-cols-2"
        v-for="lista in indicadores"
      >
        <div class="border-r">
          {{ lista.delegacion }}
        </div>
        <div class="text-center">
          {{ lista.total }}
        </div>
      </div>
    </div>
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
  watch: {},
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


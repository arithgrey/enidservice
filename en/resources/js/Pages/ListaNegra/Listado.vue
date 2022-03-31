<template>
  <app-layout title="Listado">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div class="bg-white p-2">
        <en-input>
          <template #label> Busqueda</template>
          <template #input>
            <input
              class="format_input"
              v-model="q"
              placeholder="¿Nombre o número?"
            />
          </template>
        </en-input>
      </div>
      <table class="w-full">
        <tbody>
          <tr @click="showUser(lista)"
            class="border-b-2 border-blue-600 cursor-pointer"
            v-for="lista in lista_negra.data"
          >
            <td>{{ lista.user.name.toUpperCase() }}</td>
            <td>{{ lista.user.tel_contacto }}</td>
          </tr>
        </tbody>
      </table>

      <en-paginacion
        ref="enpaginacion"
        class="mt-6"
        :links="lista_negra.links"
      />
    </div>
    <ShowModal ref="showModal" />
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import ShowModal from "./ShowModal";

export default defineComponent({
  components: {
    ShowModal,
  },
  props: {
    lista_negra: Object,
  },
  data() {
    return {
      q: "",
    };
  },
  watch: {
    q: function (value) {
      this.busqueda();
    },
  },
  methods: {
    showUser: function (lista) {

      this.$refs.showModal.muestraModal(lista);
    },
    busqueda: function busqueda() {
      let params = { q: this.q };
      this.$inertia.replace(this.route("lista-negra.index", params));
    },
  },
});
</script>

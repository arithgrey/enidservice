<template>
  <Head title="Enid service" />
  <div class="w-11/12 mx-auto">
    <div class="mt-2 mb-4">
      <a
        class="
          bg-neutral-900
          p-1
          font-bold
          text-white text-center
          border-slate-50
          mb-1
          cursor-pointer
        "
        target="_black"
        :href="path_enid"
      >
        Enid Service
      </a>
    </div>
    <div>
      <div class="ml-auto cursor-pointer" @click="crearListaNegra()">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 cursor-pointer"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
      </div>
    </div>

    <div class="grid grid-cols-1">
      <div class="sm:w-full lg:w-1/3 mt-5 mb-5 mx-auto">
        <en-input>
          <template #label> Busqueda</template>
          <template #input>
            <input
              class="format_input"
              v-model="q"
              placeholder="¿Nombre, número, Facebook?"
            />
          </template>
        </en-input>
      </div>
    </div>

    <div
      class="
        grid grid-cols-5
        mt-5
        gap-5
        border-b-2
        text-center
        border-blue-600
        cursor-pointer
      "
      v-for="lista in lista_negra.data"
    >
      <div class="text-xs">
        {{ lista.user.name.toUpperCase() }}
      </div>
      <div>
        <p v-if="lista.user.tel_contacto">
          {{ lista.user.tel_contacto }}
        </p>
        <p v-else>-</p>
      </div>
      <div class="text-center">
        <a
          v-if="lista.user.facebook"
          class="font-bold"
          :href="lista.user.facebook"
          target="_blank"
        >
          Facebook
        </a>
        <p v-else>-</p>
      </div>
      <div>
        <a
          v-if="lista.user.url_lead"
          class="font-bold"
          :href="lista.user.url_lead"
          target="_blank"
        >
          Conversación de facebook
        </a>
        <p v-else>-</p>
      </div>
      <div>
        <p
          @click="showUser(lista)"
          class="
            bg-neutral-900
            p-1
            font-bold
            text-white text-center
            border-slate-50
            mb-1
          "
        >
          Es lista negra
        </p>
      </div>
    </div>
    <OrdenComentario ref="ordenComentario" />
    <Ppfp ref="ppfp" />
    <ShowModal ref="showModal" />
    <CrearModal ref="crearModal" />
  </div>

</template>

<!--
<style>
body * {
  border: solid 1px blue !important;
}
</style>
--->
<script>
import { defineComponent } from "vue";
import ShowModal from "./ShowModal";
import CrearModal from "./CrearModal";
import OrdenComentario from "../OrdenComentario/Listado";
import Ppfp from "../Ppfp/Listado";

export default defineComponent({
  components: {
    ShowModal,
    CrearModal,
    OrdenComentario,
    Ppfp,
  },
  props: {
    lista_negra: Object,
  },
  data() {
    return {
      q: "",
      regitro_lead: 0,
      path_enid: "https://enidservices.com/",
    };
  },
  watch: {
    q: function (value) {
      this.busqueda();
      this.busquedaOrdenComentario();
      this.busquedaPpfp();
    },
  },
  methods: {
    crearListaNegra: function () {
      this.$refs.crearModal.formModal();
    },

    busquedaPpfp: function () {
      this.$refs.ppfp.busqueda(this.q);
    },
    busquedaOrdenComentario: function () {
      this.$refs.ordenComentario.busqueda(this.q);
    },
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

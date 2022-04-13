<template>
  <app-layout title="Listado">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <!--
    <div class="ml-auto">
      <en-boton @click="crearListaNegra()"> Agregar </en-boton>
    </div>
    -->

      <div class="w-1/3 mx-auto">
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

    <div v-if="lista_negra.data" class="w-2/3 mx-auto mt-5">
      <p class="font-bold">
        Busqueda en lista negra
      </p>
    </div>
      <table class="w-2/3 mx-auto
       mt-5">
        <tbody>
          <tr
            class="border-b-2 border-blue-600 cursor-pointer"
            v-for="lista in lista_negra.data"
          >
            <td>
              {{ lista.user.name.toUpperCase() }}
            </td>
            <td>{{ lista.user.tel_contacto }}</td>
            <td v-if="lista.user.facebook">
              <a class="font-bold" :href="lista.user.facebook" target="_blank">
                Facebook
              </a>
            </td>
            <td v-if="lista.user.url_lead">
              <a class="font-bold" :href="lista.user.url_lead" target="_blank">
                Conversación de facebook
              </a>
            </td>
            <td>
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
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <OrdenComentario ref="ordenComentario"/>
    <Ppfp ref="ppfp"/>
    <ShowModal ref="showModal" />
    <CrearModal ref="crearModal" />
  </app-layout>
</template>

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
    busquedaPpfp: function() {
        this.$refs.ppfp.busqueda(this.q);
    },
    busquedaOrdenComentario: function() {
        this.$refs.ordenComentario.busqueda(this.q);
    },
    showUser: function (lista) {
      this.$refs.showModal.muestraModal(lista);
    },
    crearListaNegra: function () {
      this.$refs.crearModal.muestraModal();
    },
    busqueda: function busqueda() {
      let params = { q: this.q };
      this.$inertia.replace(this.route("lista-negra.index", params));
    },
  },
});
</script>

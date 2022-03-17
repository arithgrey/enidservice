<template>
  <app-layout title="Listado">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-10">
        <div class="bg-white p-2">
          <div class="flex">
            <div class="flex-none">
              <select v-model="status">
                <option value="0">Por liquidar</option>
                <option value="1">Pagados</option>
              </select>
            </div>

            <div class="ml-2 flex-1 w-64">
              <en-input>
                <template #label> Busqueda</template>
                <template #input>
                  <input
                    class="format_input"
                    v-model="q"
                    placeholder="¿A quíen quieres buscar?"
                  />
                </template>
              </en-input>
            </div>
          </div>
        </div>
        <div class="p-2">
          <ol
            class="border-l-2 border-blue-600"
            v-for="solicitud in solicitudes_retiro.data"
          >
           <li>
              <div class="flex flex-start items-center">
                <div
                  class="
                    bg-blue-600
                    w-4
                    h-4
                    flex
                    items-center
                    justify-center
                    rounded-full
                    -ml-2
                    mr-3
                    -mt-4
                  "
                ></div>
                <img
                  class="h-8 w-8 rounded-full object-cover mr-3 mt-5"
                  :src="solicitud.user.profile_photo_url"
                />

                <h4
                  class="text-gray-800 font-semibold mt-5 cursor-pointer"
                  @click="showSolicitudRetiro(solicitud)"
                >
                  {{ solicitud.user.name }}
                </h4>

                <span
                  v-if="solicitud.status > 0"
                  class="
                    font-semibold
                    py-1.5
                    px-2.5
                    mt-4
                    bg-black
                    text-white
                    rounded
                    flex
                    ml-auto
                  "
                >
                  <span class="mr-2"> {{ solicitud.monto }} MXN </span>
                  <span>
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-6 w-6"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                      />
                    </svg>
                  </span>
                </span>

                <span
                  v-else
                  class="
                    font-semibold
                    py-1.5
                    px-2.5
                    mt-4
                    bg-teal-600
                    text-white
                    rounded
                    ml-auto
                  "
                >
                  {{ solicitud.monto }} MXN
                </span>
              </div>
              <div class="ml-6 mb-6 pb-6">
                <a
                  href="#!"
                  class="
                    text-blue-600
                    hover:text-blue-700
                    focus:text-blue-800
                    duration-300
                    transition
                    ease-in-out
                    text-sm
                  "
                  >{{ solicitud.creado }}</a
                >
              </div>
            </li>
          </ol>
        </div>
      </div>

      <div
        class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
      ></div>

      <en-paginacion
        ref="enpaginacion"
        class="mt-6"
        :links="solicitudes_retiro.links"
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
      ShowModal
  },
  props: {
    solicitudes_retiro: Object,

  },

  data() {
    return {
      q: "",
      status: 0,
    };
  },
  watch: {
    q: function (value) {
      this.busqueda();
    },
    status: function (value) {
      this.busqueda();
    },
  },
  methods: {
    showSolicitudRetiro: function (solicitud) {

      this.$refs.showModal.muestraModal(solicitud);
    },
    busqueda: function busqueda() {
      let params = { q: this.q, status: this.status };
      this.$inertia.replace(this.route("solicitud-retiro.index", params));
    },
  },
});
</script>

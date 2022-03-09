<template>
  <app-layout title="Listado">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-10">
        <div class="bg-white p-2">
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
        <div class="p-2">
          <ol
            class="border-l-2 border-blue-600"
            v-for="solicitud in solicitudes_retiro.data"
          >
            <li >
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

                <h4 class="text-gray-800 font-semibold mt-5">
                  {{ solicitud.user.name }}
                </h4>

                <span class="font-semibold py-1.5 px-2.5 mt-4 bg-blue-600 text-white rounded ml-auto">
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
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  components: {},
  props: {
    solicitudes_retiro: Object,
  },
  data() {
    return {
      q: "",
    };
  },
  watch: {
    q: function (value) {
      this.$inertia.replace(this.route("solicitud-retiro.index", { q: value }));
    },
  },
  methods: {},
});
</script>

<template>
  <app-layout title="Listado">
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
      <div>
        <div
          class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
        ></div>
        <div class="bg-white flex flex-col">
          <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
              class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-10"
            >
              <div class="bg-white p-2">

                <en-input v-bind:input="inputBusqueda">
                    <template #label>
                        Busqueda
                    </template>
                    <template #input>
                        <input class="format_input" v-model="q" placeholder="¿Qué quieres buscar?">
                    </template>
                </en-input>
              </div>
              <div
                class="
                  shadow
                  overflow-hidden
                  border-b border-gray-200
                  sm:rounded-lg
                "
              >
                <table class="w-full">
                  <tbody class="">
                    <tr v-for="valoracion in valoraciones">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="flex-shrink-0 h-10 w-10">
                            <img
                              class="h-10 w-10 rounded-full"
                              src="{{valoracion.imagen}}"
                              alt=""
                            />
                          </div>
                          <div class="ml-4">
                            <valoracion-puntuacion
                              v-bind:valoracion="valoracion"
                            />
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <Link :href="route('valoracion.show', valoracion.id)">
                          {{ valoracion.titulo }}
                        </Link>

                        <div class="text-sm text-gray-500">
                          {{ valoracion.excerpt }}
                        </div>
                      </td>
                      <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm"
                      >
                        <Link :href="route('valoracion.show', valoracion.id)">
                          <valoracion-recomendaria
                            v-bind:valoracion="valoracion"
                          />
                        </Link>
                      </td>
                      <td
                        class="px-6 py-4 whitespace-nowrap text-right text-sm"
                      >
                        <Link :href="route('valoracion.edit', valoracion.id)">
                          Editar
                        </Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div
          class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
        ></div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import ValoracionPuntuacion from "./ValoracionPuntuacion";
import ValoracionRecomendaria from "./ValoracionRecomendaria";
import { Head, Link } from "@inertiajs/inertia-vue3";
import EnInput from "../Components/Form/EnInput";

export default {
  components: {
    AppLayout,
    ValoracionPuntuacion,
    ValoracionRecomendaria,
    Link,
    EnInput,
  },
  props: {
    valoraciones: Array,
  },
  data() {
    return {
      q: '',
      inputBusqueda: {
        texto_label: "Busqueda",
        type: "text",
        name: "q",
        placeholder: "",
        class_input: "w-3/4",
        v_model: "q",
      },
    };
  },
  watch: {
    q: function (value) {
      this.$inertia.replace(this.route("valoracion.index", { q: value }));
    },
  },
};
</script>




















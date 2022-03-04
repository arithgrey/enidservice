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
                <en-input>
                  <template #label> Busqueda</template>
                  <template #input>
                    <input
                      class="format_input"
                      v-model="q"
                      placeholder="¿Qué quieres buscar?"
                    />
                  </template>
                </en-input>
              </div>
              <div>
                <table class="w-full">
                  <tbody>
                    <tr
                      v-for="valoracion in valoraciones.data"
                      class="border-b border-gray-200"
                    >
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <div class="ml-4">
                            <valoracion-puntuacion :valoracion="valoracion" />
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
                          <valoracion-recomendaria :valoracion="valoracion" />
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
      <en-paginacion
        ref="enpaginacion"
        class="mt-6"
        :links="valoraciones.links"
      />
    </div>
  </app-layout>
</template>

<script>

import { defineComponent } from "vue";
import ValoracionPuntuacion from "./ValoracionPuntuacion";
import ValoracionRecomendaria from "./ValoracionRecomendaria";
import EnPaginacion from "../Components/EnPaginacion";

export default defineComponent({
  components: {
    ValoracionPuntuacion,
    ValoracionRecomendaria,
    EnPaginacion,
  },
  props: {
    valoraciones: Object,
  },
  data() {
    return {
      q: "",
    };
  },
  watch: {
    q: function (value) {
      this.$inertia.replace(
        this.route("valoracion.index", { q: value})
      );
    },
  },
  methods: {

  },
});
</script>

<template>
  <div>
    <div
      class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
    ></div>
    <div class="flex flex-col">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-10">
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
                          src="{{valoracion.imagen }}"
                          alt=""
                        />
                      </div>
                      <div class="ml-4">
                        <valoracion-puntuacion v-bind:valoracion="valoracion" />
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <Link :href="route('valoracion.show', valoracion.slug)">
                      {{ valoracion.titulo }}
                    </Link>

                    <div class="text-sm text-gray-500">
                      {{ valoracion.excerpt }}
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                    <Link :href="route('valoracion.show', valoracion.slug)">
                      <valoracion-recomendaria v-bind:valoracion="valoracion" />
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
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ValoracionPuntuacion from "./ValoracionPuntuacion";
import ValoracionRecomendaria from "./ValoracionRecomendaria";

export default defineComponent({
  components: {
    Head,
    Link,
    ValoracionPuntuacion,
    ValoracionRecomendaria,
  },

  props: {
    valoraciones: Array,
  },
});
</script>

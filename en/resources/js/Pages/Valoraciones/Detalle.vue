<template>
  <app-layout title="">
    <div class="max-w-md mx-auto mt-6">
      <div class="flex flex-col">
      <div class="ml-auto">
        <Link :href="route('valoracion.edit', valoracion.id)">
          <en-editar />
        </Link>
      </div>

      <div>
        <div class="divide-y divide-gray-300/50">
          <div class="flex items-end justify-between">
            <valoracion-recomendaria v-bind:valoracion="valoracion" />
            <valoracion-puntuacion v-bind:valoracion="valoracion" />
          </div>
          <div class="py-8 text-base leading-7 space-y-6 text-gray-600">
            <p>{{ valoracion.titulo }}</p>
            <ul class="space-y-4">
              <li class="flex items-center">
                <svg
                  class="w-6 h-6 flex-none fill-sky-100 stroke-sky-500 stroke-2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                >
                  <circle cx="12" cy="12" r="11" />
                  <path
                    d="m8 13 2.165 2.165a1 1 0 0 0 1.521-.126L16 9"
                    fill="none"
                  />
                </svg>
                <p class="ml-4">
                  {{ valoracion.comentario }}
                </p>
              </li>
            </ul>
          </div>
          <div class="pt-8 text-base leading-7 font-semibold">
            <p class="text-gray-900">{{ valoracion.fecha_registro }}</p>
          </div>
        </div>
      </div>
    </div>
    </div>
  </app-layout>
</template>



<script>
import { defineComponent } from "vue";
import ValoracionPuntuacion from "./ValoracionPuntuacion";
import ValoracionRecomendaria from "./ValoracionRecomendaria";
import EnEditar from "../Components/Form/EnEditar";

export default defineComponent({
  components: {
    ValoracionPuntuacion,
    ValoracionRecomendaria,
    EnEditar,
  },

  props: {
    valoracion: Object,
  },
  data() {
    return {
      btn: {
        titulo: "Editar",
      },
    };
  },
});
</script>

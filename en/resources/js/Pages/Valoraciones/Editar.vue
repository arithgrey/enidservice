<template>
  <app-layout title="Listado">
    <div class="max-w-md mx-auto mt-6">
      <div class="flex flex-col">
        <div class="ml-auto">
          <a href="#" @click.prevent="confirma_eliminar" class="ml-auto">
            <en-eliminar :atributos="eliminar" />
          </a>
        </div>
        <div class="divide-y divide-gray-300/50 mt-4">
          <div class="flex items-end justify-between">
            <valoracion-recomendaria :valoracion="valoracion" />
            <valoracion-puntuacion :valoracion="valoracion" />
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
            <form @submit.prevent="submit">
              <div class="flex justify-center">
                <div class="text-sm mr-1">
                  <select
                    class="text-sm focus:outline-none -ml-1"
                    v-model="form.status"
                    name="status"
                  >
                    <option value="1">Mostrar en reseñas</option>
                    <option value="0">Ocultar esta reseña al público</option>
                  </select>
                </div>
                <div class="">
                  <en-boton :atributos="btn"> Actualizar </en-boton>
                </div>
              </div>
            </form>
            <p class="text-gray-900">{{ valoracion.fecha_registro }}</p>
          </div>
        </div>
      </div>
    </div>

    <EnModal ref="enModal" :confirmModal="true" @confirma="destroy">
      <template #contenido>
        <div>Deseas eliminar la reseña?</div>
      </template>
    </EnModal>
  </app-layout>
</template>


<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import ValoracionPuntuacion from "./ValoracionPuntuacion";
import ValoracionRecomendaria from "./ValoracionRecomendaria";
import EnBoton from "../Components/Form/EnBoton";
import EnEliminar from "../Components/Form/EnEliminar";
import EnModal from "../Components/Form/EnModal";

export default defineComponent({
  components: {
    Head,
    Link,
    ValoracionPuntuacion,
    ValoracionRecomendaria,
    EnBoton,
    EnEliminar,
    AppLayout,
    EnModal,
  },

  props: {
    valoracion: Object,
  },
  data() {
    return {
      btn: {},
      form: this.$inertia.form({
        status: this.valoracion.status,
      }),
    };
  },

  methods: {
    submit() {
      let url = this.route("valoracion.update", this.valoracion.id);
      let data = this.form;
      let response = this.$inertia.put(url, data);
    },
    confirma_eliminar() {
      this.$refs.enModal.toggleModal();
    },
    destroy() {
      let url = this.route("valoracion.destroy", this.valoracion.id);
      this.$inertia.delete(url);
    },
  },
});
</script>

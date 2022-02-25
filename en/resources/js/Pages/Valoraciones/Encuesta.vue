<template>
  <app-layout title="Listado">
    <div class="grid mt-5">
      <div class="mx-auto">
        <div>
          <h1 class="format_titulo">ESCRIBE UNA RESEÑA</h1>
        </div>
        <div>Sobre tu servicio</div>
        <div>
          <form @submit.prevent="registrar(form)">
            <div class="flex flex-col">
              <div class="mt-3">
                <h2 class="font-semibold text-xl">
                  ¿Qué valoración darías a este artículo?
                </h2>
              </div>
              <div class="mr-auto">
                <p class="clasificacion ltr">
                  <input
                    id="radio1"
                    class="hidden"
                    type="radio"
                    name="calificacion"
                    v-model="form.calificacion"
                    value="5"
                  />
                  <label class="text-5xl text-slate-300" for="radio1">★</label>
                  <input
                    id="radio2"
                    class="hidden"
                    type="radio"
                    name="calificacion"
                    v-model="form.calificacion"
                    value="4"
                  />
                  <label class="text-5xl text-slate-300" for="radio2">★</label>
                  <input
                    id="radio3"
                    class="hidden"
                    type="radio"
                    name="calificacion"
                    v-model="form.calificacion"
                    value="3"
                  />
                  <label class="text-5xl text-slate-300" for="radio3">★</label>
                  <input
                    id="radio4"
                    class="hidden"
                    type="radio"
                    name="calificacion"
                    v-model="form.calificacion"
                    value="2"
                  />
                  <label class="text-5xl text-slate-300" for="radio4">★</label>
                  <input
                    id="radio5"
                    class="hidden"
                    type="radio"
                    name="calificacion"
                    v-model="form.calificacion"
                    value="1"
                  />
                  <label class="text-5xl text-slate-300" for="radio5">★</label>
                </p>
              </div>
              <p v-if="errors.calificacion" class="format_error">
                {{ errors.calificacion }}
              </p>
            </div>
            <div class="mt-3">
              <label class="font-semibold">
                ¿Recomendarías este producto?*
              </label>
            </div>
            <div class="flex flex-row justify-between mt-4">
              <div>
                <a
                  v-bind:class="selectorRecomendaria"
                  class="format_selector"
                  v-on:click="valorar"
                >
                  SI
                </a>
              </div>
              <div>
                <a
                  v-bind:class="selectorSinRecomendacion"
                  class="format_selector format_selector_sin_valoracion"
                  v-on:click="sinvalorar"
                >
                  NO
                </a>
              </div>
            </div>
            <div v-if="errors.recomendaria" class="format_error mt-3">
              {{ errors.recomendaria }}
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputOpinion">
                <template #label> Tu opinión en una frase* </template>
                <template #input>
                  <input
                    type="text"
                    class="w-full format_input"
                    name="titulo"
                    v-model="form.titulo"
                    placeholder="Me encantó!"
                  />
                </template>
                <template #errores>
                  <div v-if="errors.titulo" class="format_error">
                    {{ errors.titulo }}
                  </div>
                </template>
              </en-input>
            </div>
            <div class="mt-3">
              <en-text-area v-bind:input="inputComentario">
                <template #label> Tu reseña (comentarios)* </template>
                <template #area>
                  <textarea
                    class="format_text_area w-full comentario"
                    name="comentario"
                    v-model="form.comentario"
                    id="comentario"
                    placeholder="¿Cual fué tu experiencia?"
                  ></textarea>
                </template>
                <template #errores>
                  <div v-if="errors.comentario" class="format_error">
                    {{ errors.comentario }}
                  </div>
                </template>
              </en-text-area>
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputNombre">
                <template #label> Tu nombre* </template>
                <template #input>
                  <input
                    type="text"
                    name="nombre"
                    v-model="form.nombre"
                    class="w-full format_input"
                    placeholder="ejemplo: Jonathan"
                    id="nombre"
                  />
                </template>
                <template #errores>
                  <div v-if="errors.nombre" class="format_error">
                    {{ errors.nombre }}
                  </div>
                </template>
              </en-input>
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputEmail">
                <template #label> Tu email* </template>
                <template #input>
                  <input
                    type="email"
                    name="email"
                    v-model="form.email"
                    class="email format_input mt-2 w-full"
                    placeholder="ejemplo:jmedrano@enidservices.com"
                  />
                </template>
                <template #errores>
                  <div v-if="errors.email" class="format_error">
                    {{ errors.email }}
                  </div>
                </template>
              </en-input>
            </div>
            <input
              type="hidden"
              name="recomendaria"
              v-model="form.recomendaria"
              class="recomendaria hiden"
            />
            <input
              type="hidden"
              name="id_servicio"
              v-model="form.id"
              class="id_servicio hiden"
            />

            <select v-model="form.id_tipo_valoracion" name="id_tipo_valoracion">
              <option disabled value="">Seleccione un elemento</option>
              <option
                v-for="tipo_valoracion in tipos_valoraciones"
                v-bind:value="tipo_valoracion.id"
              >
                {{ tipo_valoracion.nombre }}
              </option>
            </select>
            <div v-if="errors.id_tipo_valoracion" class="format_error">
              {{ errors.id_tipo_valoracion }}
            </div>
            <div class="mt-3 mb-3">
              <en-boton> Enviar Reseña </en-boton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>



<script>
import { defineComponent } from 'vue'
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import EnInput from "../Components/Form/EnInput";
import EnTextArea from "../Components/Form/EnTextArea";
import EnBoton from "../Components/Form/EnBoton";


export default defineComponent({
  components: {
    Head,
    Link,
    EnInput,
    EnTextArea,
    EnBoton,
    AppLayout,
  },

  props: {
    errors: Object,
    id: Array,
    tipos_valoraciones: Object,
  },
  data() {
    return {

      btn: {},
      selectorRecomendaria: {
        format_selector_seleccionado: false,
      },
      selectorSinRecomendacion: {
        format_selector_seleccionado: false,
      },
      form: this.$inertia.form({
        comentario: this.comentario,
        calificacion: this.calificacion,
        recomendaria: this.recomendaria,
        titulo: this.titulo,
        email: this.email,
        nombre: this.nombre,
        id_servicio: this.id,
        id_tipo_valoracion: this.id_tipo_valoracion,
      }),
    };
  },
  methods: {
    openModal: function () {

    },
    registrar: function (form) {
      let url = this.route("valoracion.store");
      this.$inertia.post(url, form);
    },
    valorar: function (event) {
      this.form.recomendaria = 1;
      this.selectorRecomendaria.format_selector_seleccionado = true;
      this.selectorSinRecomendacion.format_selector_seleccionado = false;
    },
    sinvalorar: function (event) {
      this.form.recomendaria = 0;
      this.selectorRecomendaria.format_selector_seleccionado = false;
      this.selectorSinRecomendacion.format_selector_seleccionado = true;
    }
  },
});
</script>
<style scoped>
.clasificacion {
  direction: rtl;
}

.clasificacion label:hover,
.clasificacion label:hover ~ label {
  color: #040e31;
  cursor: pointer;
}

.clasificacion input[type="radio"]:checked ~ label {
  color: #040e31;
}
</style>

<template>
  <app-layout>
    <Head title="Enid service" />
    <en-navbar />
    <div class="grid mt-5">
      <div class="mx-auto">
        <div>
          <h1>ESCRIBE UNA RESEÑA</h1>
        </div>
        <div>Sobre tu servicio</div>
        <div>
          <form>
            <div class="flex flex-col">
              <div class="mt-3">
                <h2 class="font-semibold text-xl">
                  ¿Qué valoración darías a este artículo?
                </h2>
              </div>
              <div class="mr-auto">
                <p class="clasificacion">
                  <input
                    id="radio1"
                    type="radio"
                    name="calificacion"
                    value="5"
                  />
                  <label class="text-5xl" for="radio1">★</label>
                  <input
                    id="radio2"
                    type="radio"
                    name="calificacion"
                    value="4"
                  />
                  <label class="text-5xl" for="radio2">★</label>
                  <input
                    id="radio3"
                    type="radio"
                    name="calificacion"
                    value="3"
                  />
                  <label class="text-5xl" for="radio3">★</label>
                  <input
                    id="radio4"
                    type="radio"
                    name="calificacion"
                    value="2"
                  />
                  <label class="text-5xl" for="radio4">★</label>
                  <input
                    id="radio5"
                    type="radio"
                    name="calificacion"
                    value="1"
                  />
                  <label class="text-5xl" for="radio5">★</label>
                </p>
              </div>
            </div>
            <div class="mt-3">
              <label class="font-semibold">
                ¿Recomendarías este producto?*
              </label>
            </div>
            <div class="flex flex-row justify-between mt-4">
              <div>
                <a class="format_selector"> SI </a>
              </div>
              <div>
                <a class="format_selector"> NO </a>
              </div>
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputOpinion" />
            </div>
            <div class="mt-3">
              <en-text-area v-bind:input="inputComentario" />
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputNombre" />
            </div>

            <div class="mt-3 mb-3">
              <en-input v-bind:input="inputEmail" />
            </div>
            <div class="mt-3 mb-3">
                <en-boton v-bind:atributos="btn"/>
            </div>
          </form>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { defineComponent } from "vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import EnNavbar from "../Components/EnNavbar";
import EnInput from "../Components/Form/EnInput";
import EnTextArea from "../Components/Form/EnTextArea";
import EnBoton from "../Components/Form/EnBoton";

export default defineComponent({
  components: {
    Head,
    Link,
    EnNavbar,
    EnInput,
    EnTextArea,
    EnBoton,
  },

  props: {},
  data() {
    return {
      inputOpinion: {
        texto_label: "Tu opinión en una frase*",
        type: "text",
        name: "titulo",
        placeholder: "Me encantó!",
      },
      inputComentario: {
        texto_label: "Tu reseña (comentarios)*",
        name: "comentario",
        class: "comentario",
        id: "comentario",
        placeholder: "¿Cual fué tu experiencia?",
        old: "",
      },
      inputNombre: {
        texto_label: "Tu nombre",
        type: "text",
        name: "nombre",
        placeholder: "ejemplo: Jonathan",
        id: "nombre",
      },
      inputEmail: {
        texto_label: "Tu email*",
        type: "email",
        name: "email",
        class: "email mt-2",
        placeholder: "ejemplo: jmedrano@enidservices.com",
      },
      btn:{
          titulo:"Enviar Reseña"
      }
    };
  },
});
</script>

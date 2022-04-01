s<template>
  <EnModal ref="enModal">
    <template #contenido>
      <div class="flex flex-col items-center justify-center bg-white">

          <form @submit.prevent="registrar(form)">
            <div class="flex flex-col">
              <div class="mt-3">
                <h2 class="font-semibold text-xl">
                  Agregar a lista negra
                </h2>
              </div>
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
              <en-input v-bind:input="inputTelefono">
                <template #label> Teléfono </template>
                <template #input>
                  <input
                    type="telefono"
                    name="telefono"
                    v-model="form.telefono"
                    class="telefono format_input mt-2 w-full"
                    placeholder="ejemplo: 5552961028"
                  />
                </template>
                <template #errores>
                  <div v-if="errors.telefono" class="format_error">
                    {{ errors.telefono }}
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
              <en-boton> Registrar </en-boton>
            </div>
          </form>

      </div>
    </template>
  </EnModal>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "crear-modal",
  components: {},
  props: {
      errors: Object,
  },
  data() {
    return {
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
      errors:Object,

    };
  },
  methods: {
    muestraModal: function () {

        this.$refs.enModal.toggleModal();
    },
    registrar: function (form) {

    },
  },
});
</script>

<template>
  <EnModal ref="enModal">
    <template #contenido>
      <form @submit.prevent="registrar(form)">
        <div class="bg-slate-900 text-white mb-5 p-2">
          Registra datos de personas que puedan implicar un riesgo al momento de
          su entrega
        </div>
        <select v-model="form.tipo" class="min-w-full mt-3 mb-3">
          <option value="0">Cuidado al contactar</option>
          <option value="1">
            Lista negra (No le vendemos a menos de que pague antes)
          </option>
        </select>

        <en-input
          >Nombre
          <template #label> Nombre</template>
          <template #input>
            <input
              class="format_input"
              v-model="form.name"
              placeholder="¿Nombre?"
            />
            <p v-if="errors.name" class="format_error">
              {{ errors.name[0] }}
            </p>
          </template>
        </en-input>

        <div
          v-if="identificador > 0"
          class="mt-4 mb-3 p-2 border-4 border-sky-500"
        >
          Registra el
          <span class="font-bold"> número telefónico </span>
          o
          <span class="font-bold"> Facebook </span>
          para identificarlo
        </div>
        <en-input>
          <template #label> Teléfono</template>
          <template #input>
            <input
              class="format_input"
              v-model="form.tel_contacto"
              placeholder="¿Teléfono?"
              type="tel"
            />
            <p v-if="errors.tel_contacto" class="format_error">
              {{ errors.tel_contacto[0] }}
            </p>
          </template>
        </en-input>

        <en-input
          >Facebook
          <template #label> Facebook</template>
          <template #input>
            <input
              class="format_input"
              v-model="form.facebook"
              placeholder="¿Facebook?"
              type="url"
            />
          </template>
        </en-input>

        <en-text-area>
          <template #label> Comentarios* </template>
          <template #area>
            <textarea
              class="format_text_area w-full comentario"
              name="comentario"
              v-model="form.comentario"
              id="comentario"
              placeholder="¿Cual fué tu experiencia?"
            ></textarea>
          </template>
        </en-text-area>
        <div class="mt-3 mb-3">
          <en-boton> Enviar reporte </en-boton>
        </div>
      </form>
      <div v-if="registrado > 0">
        <div class="bg-blue-800 p-1 shadow-md text-white">
          <h3 class="font-semibold text-lg mb-1">Registrado</h3>
        </div>
      </div>
    </template>
  </EnModal>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "crear-modal",
  components: {},
  props: {},
  data() {
    return {
      errors: [],
      registrado: 0,
      identificador: 0,
      form: this.$inertia.form({
        tipo: 0,
        name: "",
        tel_contacto: "",
        facebook: "",
        comentario: "Persona Irrespetuosa",
      }),
    };
  },
  methods: {
    formModal: function () {
      this.$refs.enModal.toggleModal();
    },
    registrar: function (form) {
      if (form.tel_contacto.length > 5 || form.facebook.length > 10) {
        axios
          .post(route("lead.store"), form)
          .then((data) => {
            debugger;
            this.registrado = 1;
          })
          .catch((error) => {
            debugger;
            this.errors = error.response.data.errors;
          });
        this.identificador = 0;
      } else {
        this.identificador = 1;
      }
    },
  },
});
</script>

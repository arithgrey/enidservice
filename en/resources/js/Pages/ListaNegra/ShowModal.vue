<template>
  <EnModal ref="enModal">
    <template #contenido>
      <div class="flex flex-col items-center justify-center bg-white">
        <a>
          <div class="grid grid-cols-6 p-5 gap-y-2">
            <div>
              <img
                :src="lista_negra.user.profile_photo_url"
                class="max-w-16 max-h-16 rounded-full"
              />
            </div>

            <div class="col-span-5 md:col-span-4 ml-4">
              <p class="text-black font-bold">
                {{ lista_negra.user.name }}
              </p>
              <div class="font-bold mt-2">Identificadores</div>

              <div class="text-gray-400">
                {{ lista_negra.user.tel_contacto }}
              </div>

              <p class="mt-2">
                <span class="text-black">
                  <a v-if="facebook" :href="facebook" target="_blank"
                    >Facebook</a
                  >
                </span>
              </p>
              <p class="mt-1">
                <span class="text-black">
                  <a v-if="url_lead" :href="url_lead" target="_blank"
                    >Conversación de Facebook</a
                  >
                </span>
              </p>


              <div class="mt-4">
                <div class="font-bold">Motivo</div>
                <div>
                  {{ lista_negra.motivo.motivo.toUpperCase() }}
                </div>
              </div>
            </div>

            <div
              class="
                flex
                col-start-2
                ml-4
                md:col-start-auto md:ml-0 md:justify-end
              "
            ></div>
          </div>
        </a>
      </div>
    </template>
  </EnModal>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  name: "show-modal",
  components: {},
  props: {},
  data() {
    return {
      lista_negra: Object,
      facebook: "",
    };
  },
  methods: {
    muestraModal: function (lista_negra) {
      this.lista_negra = lista_negra;
      this.facebook = lista_negra.user.facebook;
      this.url_lead = lista_negra.user.url_lead;
      this.$refs.enModal.toggleModal();
    },
  },
});
</script>

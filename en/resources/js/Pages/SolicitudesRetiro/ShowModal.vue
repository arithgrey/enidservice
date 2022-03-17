<template>
  <EnModal ref="enModal">
    <template #contenido>
      <div class="flex flex-col gap-4 items-center justify-center bg-white">
        <a>
          <p
            v-if="solicitud.status"
            class="
              bg-sky-500
              w-fit
              px-4
              py-1
              text-sm
              font-bold
              text-white
              rounded-tl-lg rounded-br-xl
            "
          >
            PAGADO!
          </p>
          <p
            v-else
            class="
              bg-sky-500
              w-fit
              px-4
              py-1
              text-sm
              font-bold
              text-white
              rounded-tl-lg rounded-br-xl
            "
          >
            PENDIENTE DE LIQUIDAR!
          </p>

          <div class="grid grid-cols-6 p-5 gap-y-2">
            <div>
              <img
                :src="solicitud.user.profile_photo_url"
                class="max-w-16 max-h-16 rounded-full"
              />
            </div>

            <div class="col-span-5 md:col-span-4 ml-4">
              <p class="text-sky-500 font-bold text-xs">
                Comisionista {{ solicitud.user.name }}
              </p>

              <p class="text-black font-bold">
                Propietario:
                {{ solicitud.cuenta_banco.propietario }}
              </p>

              <p class="text-gray-400">
                Solicitud enviada hace {{ solicitud.creado }}
              </p>

              <img :src="banco.imagen" class="max-w-16 max-h-16 mt-2" />

              <p class="mt-2">
                  <span class="text-black font-bold">
                    Banco
                  </span>
                    {{ banco.nombre }}</p>
              <p>
                {{ solicitud.cuenta_banco.tarjeta }}
              </p>

              <p>
                {{ solicitud.cuenta_banco.banco }}
              </p>
            </div>

            <div
              class="
                flex
                col-start-2
                ml-4
                md:col-start-auto md:ml-0 md:justify-end
              "
            >
              <p
                class="
                  rounded-lg
                  text-sky-500
                  font-bold
                  bg-sky-100
                  py-1
                  px-3
                  text-sm
                  w-fit
                  h-fit
                "
              >
                {{ solicitud.monto }} MXN
              </p>
            </div>
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
      solicitud: Object,
      banco: Object,
    };
  },
  methods: {
    muestraModal: function (solicitud) {

      let id_banco = solicitud.cuenta_banco.id_banco;
      this.solicitud = solicitud;
      this.$refs.enModal.toggleModal();

      return axios.get("api/v1/banco/" + id_banco).then((response) => {
        this.banco = response.data.data;
      });
    },
  },
});
</script>

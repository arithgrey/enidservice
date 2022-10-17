<template>
  <div>
    <div>
      <p class="font-bold">Usuario - Ordenes de compra</p>
    </div>

    <div
      class="border-b-2 border-blue-600 grid grid-cols-4 py-4"
      v-for="ppfp in ppfps.data"
    >
      <div>
        <a :href="path_orden + ppfp.id_orden_compra" target="_blank">
          {{ ppfp.resumen_pedido }}
        </a>
      </div>
      <div>{{ ppfp.monto_a_pagar }}MXN</div>

      <div>{{ ppfp.tel_contacto }}</div>
      <div v-if="ppfp.facebook">
        <a class="font-bold" :href="ppfp.facebook" target="_blank">
          Facebook
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from "vue";

export default defineComponent({
  components: {},
  props: {},
  data() {
    return {
      ppfps: Object,
      path_orden: "https://enidservices.com/web/pedidos/?recibo=",
    };
  },
  methods: {
    busqueda: function (q) {
      axios.get("api/v1/usuario/ppfp/?q=" + q).then((response) => {
        this.ppfps = response.data;
      });
    },
  },
});
</script>

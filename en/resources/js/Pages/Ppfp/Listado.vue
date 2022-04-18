<template>
  <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="w-2/3 mx-auto">
      <p class="font-bold">Usuario - Ordenes de compra</p>
    </div>

    <table class="w-2/3 mx-auto mt-5">
      <tbody>
        <tr class="border-b-2 border-blue-600" v-for="ppfp in ppfps.data">
          <td>
            <a :href="path_orden + ppfp.id_orden_compra" target="_blank">
              {{ ppfp.resumen_pedido }}
            </a>
          </td>
          <td>{{ ppfp.monto_a_pagar }}MXN</td>

          <td>{{ ppfp.tel_contacto }}</td>
          <td v-if="ppfp.facebook">
            <a class="font-bold" :href="ppfp.facebook" target="_blank">
              Facebook
            </a>
          </td>
          <td v-if="ppfp.url_lead">
            <a class="font-bold" :href="ppfp.url_lead" target="_blank">
              Conversación de facebook
            </a>
          </td>
        </tr>
      </tbody>
    </table>
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

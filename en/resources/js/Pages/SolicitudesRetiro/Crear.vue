<template>
  <app-layout title="Listado">
    <div class="grid mt-5">
      <div class="mx-auto">
        <div>
            Saldo disponible
        </div>
      </div>
    </div>
  </app-layout>
</template>



<script>
import { defineComponent } from "vue";
export default defineComponent({
  components: {},
  props: {
    errors: Object,
  },
  data() {
    return {

    };
  },
  methods: {
  },
});
</script>

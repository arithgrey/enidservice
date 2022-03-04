<template>
  <div
    v-if="showModal"
    class="
      overflow-x-hidden overflow-y-auto
      fixed
      inset-0
      z-50
      outline-none
      focus:outline-none
      justify-center
      items-center
      flex
    "
  >
    <div class="relative w-2/4 my-6 mx-auto max-w-3xl">
      <!--content-->
      <div class="border-0 relative flex flex-col w-full bg-white">
        <!--header-->
        <div class="flex items-start justify-between p-5 rounded-t">
          <button
            class="ml-auto text-black float-right text-3xl font-semibold"
            v-on:click="toggleModal()"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <!--body-->
        <div class="relative p-8 flex-auto">
          <slot name="contenido"></slot>
        </div>

        <div v-if="confirmModal" class="text-right mt-2 mb-4 mr-2">
          <button
            @click="showModal = false"
            class="
              border-solid border-2 border-blue-700
              text-blue-700
              semibold
              cursor-pointer
              pr-4
              pl-4
              pt-1
              pb-1
              tracking-wide
              transition
              transform
              hover:-translate-y-1
              motion-reduce:transition-none motion-reduce:transform-none
              mr-2
              hover:bg-blue-900 hover:text-white
            "
          >
            Cancelar
          </button>
          <button
            @click="confirmaAccion"

            class="
              border-solid border-2 border-rose-600
              text-rose-600
              cursor-pointer
              pr-4
              pl-4
              pt-1
              pb-1
              tracking-wide
              transition
              transform
              hover:-translate-y-1
              motion-reduce:transition-none motion-reduce:transform-none
              mr-2
              hover:bg-neutral-900 hover:text-white
            "
          >
            Confirmar
          </button>
        </div>
      </div>
    </div>
  </div>
  <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
</template>

<script>
export default {
  name: "en-modal",
  props: {
    confirmModal: Boolean,
  },
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    toggleModal: function () {

      this.showModal = !this.showModal;
    },
    confirmaAccion:function(){
        this.showModal = false;
        this.$emit('confirma');
    }
  },
};
</script>

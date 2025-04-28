<template>
  <div>
    <!-- Thumbnail -->
    <div
      class="cursor-zoom-in bg-gray-100 rounded-lg overflow-hidden aspect-[4/5]"
      @click="showModal = true"
    >
      <img
        :src="product.image"
        :alt="product.name"
        class="w-full h-full object-cover"
      />
    </div>

    <!-- Product Details -->
    <div class="mt-3 text-left">
      <h3 class="text-base font-semibold text-gray-900">{{ product.name }}</h3>
      <p class="text-sm text-gray-500">{{ product.designer }}</p>
    </div>

    <!-- Modal Fullscreen -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-white/60 backdrop-blur-sm z-50 flex flex-col items-center justify-center"
      @click.self="showModal = false"
    >
      <button
        @click="showModal = false"
        class="absolute top-4 right-4 text-black text-3xl font-bold"
      >
        &times;
      </button>

      <img
        :src="product.image"
        :alt="product.name"
        class="max-w-full max-h-[80vh] object-contain"
      />

      <!-- Caption -->
      <div class="mt-4 text-center text-black">
        <h3 class="text-lg font-semibold">{{ product.name }}</h3>
        <p class="text-sm opacity-70">{{ product.designer }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  product: {
    type: Object,
    required: true,
  },
})

const showModal = ref(false)
</script>

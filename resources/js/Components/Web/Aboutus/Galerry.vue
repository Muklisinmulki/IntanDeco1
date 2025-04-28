<template>
  <section class="py-12 px-4 max-w-7xl mx-auto">
    <!-- Judul Galeri -->
    <div class="text-center mb-10">
      <p class="text-[#CBA146] font-medium uppercase">Our Gallery</p>
      <h2 class="text-3xl font-semibold text-[#1D2D61]">Arcitecture Interior</h2>
    </div>

    <!-- Grid Naik-Turun -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div
        v-for="(card, index) in cards"
        :key="index"
        :class="[
          'rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 relative',
          index % 2 === 0 ? 'mt-12' : 'mb-12'
        ]"
      >
        <img :src="card.image" :alt="card.title" class="h-96 w-full object-cover rounded-2xl" />
        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-sm text-center py-2 font-medium rounded-b-2xl">
          {{ card.title }}
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const cards = [
  { title: 'Full Home Interiors', image: '/images/about1.jpg' },
  { title: 'Modular Kitchen', image: '/images/about4.jpg' },
  { title: 'Modular Furniture', image: '/images/about3.jpg' },
  { title: 'Furniture & Decor', image: '/images/about4.jpg' },
]
</script>

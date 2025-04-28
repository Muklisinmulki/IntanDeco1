<template>
  <section class="grid grid-cols-1 lg:grid-cols-3 gap-6 px-8 py-16 max-w-7xl mx-auto items-start">
    <!-- Left Content -->
    <div>
      <h2 class="text-[22px] lg:text-[26px] font-semibold text-gray-800 leading-snug">
        Intan Natural Stone is an Indonesian manufacturer of handcrafted
        home decorative accessories, tableware, kitchenware, bathroom accessories, and wash basins.
      </h2>
      <p class="text-gray-500 text-sm mt-4">
        Established since 2000, with 23 years of experience, INS convinces by offering production mass capability,
        doing piece by piece quality control for mass production, achieving the best quality production performance
        with consistent timing of delivery.
      </p>
    </div>

    <!-- Middle Specializations -->
    <div class="space-y-2 text-sm text-gray-800">
      <h4 class="font-semibold mb-3">Our Products:</h4>
      <ul class="space-y-2">
        <li class="flex items-center space-x-2">
          <i class="fas fa-sink w-4"></i>
          <span>Sinks, vases & toiletries</span>
        </li>
        <li class="flex items-center space-x-2">
          <i class="fas fa-utensils w-4"></i>
          <span>Kitchen utensils & coffee tables</span>
        </li>
        <li class="flex items-center space-x-2">
          <i class="fas fa-lightbulb w-4"></i>
          <span>Lampshades & garden decorations</span>
        </li>
        <li class="flex items-center space-x-2">
          <i class="fas fa-gem w-4"></i>
          <span>Premium materials: fossil wood, onyx, marble, etc</span>
        </li>
      </ul>
    </div>

    <!-- Right Image Section -->
    <div class="relative group">
      <img
        :src="'/images/about4.jpg'"
        alt="INS Product"
        class="rounded-md w-full h-[300px] object-cover shadow-md"
      />
      <!-- Overlay text -->
      <div class="absolute left-4 bottom-16 text-white font-semibold text-xl leading-tight">
        Premium<br />Crafted Stones
      </div>
      <!-- Browse Link -->
      <div class="absolute bottom-4 left-4">
        <a href="#" class="text-xs text-black font-medium bg-white px-3 py-1 rounded-sm shadow hover:underline">
          View Our Collection &gt;
        </a>
      </div>
      <!-- Magnifier Icon -->
      <div class="absolute bottom-4 right-4">
        <i class="fas fa-search text-white text-lg"></i>
      </div>
    </div>
  </section>
</template>

<script setup>
// No script required
</script>

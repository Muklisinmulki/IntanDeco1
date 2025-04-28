<template>
  <div class="flex flex-col lg:flex-row max-w-7xl mx-auto py-4 lg:py-6 px-3 gap-3 lg:gap-6">
    <!-- Sidebar - Mobile: Collapsible -->
    <div class="lg:hidden">
      <button 
        @click="showFilters = !showFilters"
        class="flex items-center justify-between w-full p-2 bg-gray-100 rounded mb-3 text-sm"
      >
        <span class="font-medium">Filters</span>
        <svg 
          xmlns="http://www.w3.org/2000/svg" 
          class="h-4 w-4 transition-transform duration-200" 
          :class="{ 'rotate-180': showFilters }" 
          viewBox="0 0 20 20" 
          fill="currentColor"
        >
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      
      <div v-if="showFilters" class="bg-white p-3 rounded shadow mb-4 space-y-4 text-sm">
        <div>
          <h2 class="font-semibold mb-1">CATEGORIES</h2>
          <ul class="space-y-1 text-gray-700">
            <li v-for="(category, i) in categories" :key="i" class="py-1">{{ category }}</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Sidebar - Desktop -->
    <aside class="hidden lg:block w-56 flex-shrink-0 space-y-4 text-sm">
      <div>
        <h2 class="font-semibold mb-1">CATEGORIES</h2>
        <ul class="space-y-1 text-gray-700">
          <li v-for="(category, i) in categories" :key="i" class="py-1">{{ category }}</li>
        </ul>
      </div>
    </aside>

    <!-- Konten Produk -->
    <section class="flex-1">
      <!-- Toolbar -->
      <div class="flex flex-col sm:flex-row items-center justify-between mb-4 text-xs sm:text-sm text-gray-600 gap-2">
        <span>Showing 1–9 of {{ products.length }} results</span>
        <div class="flex items-center gap-2 w-full sm:w-auto">
          <label class="flex items-center w-full sm:w-auto">
            <span class="mr-1 whitespace-nowrap">Sort by:</span>
            <select class="border border-gray-300 rounded p-1 text-xs w-full max-w-[180px]">
              <option>Default</option>
              <option>Price: low to high</option>
              <option>Price: high to low</option>
            </select>
          </label>
        </div>
      </div>

      <!-- Grid Produk -->
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
        <ProductCard
          v-for="(product, index) in products"
          :key="index"
          :product="product"
          class="h-full"
        />
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-6 space-x-1">
        <button class="w-7 h-7 border text-xs flex items-center justify-center rounded">1</button>
        <button class="w-7 h-7 border text-xs flex items-center justify-center rounded">2</button>
        <button class="w-7 h-7 border text-xs flex items-center justify-center rounded">3</button>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import ProductCard from '@/Components/Web/ProductCard.vue'

const showFilters = ref(false)

const categories = [
  "Interior", "Furniture", "Lighting", "Accessories", "Toys", "Vases"
]

const products = [
  {
    id: 1,
    name: "Botol Skincare 23",
    designer: "Aesop",
    image: "/images/Produk1.png",
    price: "$266",
    variants: 3,
  },
  {
    id: 2,
    name: "Lampu Gantung",
    designer: "ModernHome",
    image: "/images/Produk2.png",
    price: "$120",
    variants: 2,
  },
  {
    id: 3,
    name: "Kursi Minimalis",
    designer: "BrandCo",
    image: "/images/Produk3.png",
    price: "$320",
    variants: 4,
  },
  {
    id: 4,
    name: "Meja Kayu",
    designer: "Interiorly",
    image: "/images/Produk4.png",
    price: "$185",
    variants: 1,
  },
  {
    id: 5,
    name: "Vas Keramik",
    designer: "Independent",
    image: "/images/Produk5.png",
    price: "$75",
    variants: 5,
  },
  {
    id: 6,
    name: "Rak Buku",
    designer: "BrandCo",
    image: "/images/Produk6.png",
    price: "$210",
    variants: 3,
  },
]

</script>
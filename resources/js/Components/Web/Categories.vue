<template>
  <div class="container mx-auto px-4 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <CategoryCard 
        v-for="category in categories" 
        :key="category.id" 
        :category="category" 
      />
    </div>
  </div>
</template>

<script setup>
import CategoryCard from '@/Components/Web/CategoryCard.vue';

const categories = [
  { id: 1, discount: "30% OFF", name: "WOODEN BOX", image: "/images/Produk1.png" },
  { id: 2, discount: "40% OFF", name: "MODERN CHAIR", image: "/images/Produk2.png" },
  { id: 3, discount: "20% OFF", name: "WOODEN BOX", image: "/images/katalog2.png" },
  
];
</script>

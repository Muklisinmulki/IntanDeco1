<template>
  <div v-if="catalogs.length > 0">
            <h2>Our Catalogs</h2>
            <div class="catalog-grid">
              <div v-for="catalog in catalogs" :key="catalog.id" class="catalog-item">
                <img :src="'/storage/' + catalog.image"  alt="Product Image" class="w-full h-48 object-cover mb-2" />
                <h3>{{ catalog.name }}</h3>
                <p>Category: {{ catalog.category.name }}</p>
              </div>
            </div>
          </div>
</template>

<script setup>
import ProductCard from '@/Components/Web/ProductCard.vue'

const catalogs = ref([]);
  const categories = ref([]);

  onMounted(async () => {
    try {
      const response = await axios.get('/api/catalogs');
      catalogs.value = response.data.catalogs;
      categories.value = response.data.categories;
    } catch (error) {
      console.error('Error fetching catalogs:', error);
    }
  });
</script>

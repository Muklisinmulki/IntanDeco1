<template>
  <div class="bg-white shadow-md rounded-2xl p-6 text-left hover:shadow-xl transition-shadow duration-300">
    <div class="flex items-center space-x-4 mb-4">
      <img :src="icon" alt="Icon" class="w-12 h-12" />
      <h4 class="text-xl font-semibold text-gray-800">{{ title }}</h4>
    </div>
    <p class="text-gray-600">{{ description }}</p>
  </div>
</template>

<script setup>
defineProps({
  icon: String,
  title: String,
  description: String
})
</script>

<style scoped>
/* Optional custom styling if needed */
</style>

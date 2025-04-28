<template>
  <div class="bg-gray-200  shadow-md rounded-lg flex items-center justify-between p-5">
    <img :src="category.image" :alt="category.name" class="w-2/5 object-contain">
    <div class="text-left w-3/5">
      <p class="text-sm text-[#CBA146] font-semibold">{{ category.discount }}</p>
      <h3 class="text-lg font-bold">{{ category.name }}</h3>
      <button class="mt-3 px-4 py-2 bg-[#CBA146] text-white rounded-md">Shop Now</button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  category: Object
});
</script>

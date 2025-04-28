<template>
  <div>
    <!-- Loading Spinner -->
    <div
      v-if="loading"
      class="fixed inset-0 z-50 flex items-center justify-center bg-white"
    >
      <div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
    </div>

    <!-- Konten Utama -->
    <div v-else class="animate-fade-in">
      <Navbar />
      <Header />
      <Content />
      <main class="container mx-auto">
        <VisiMisi />
        <Keunggulan />
        <Gallery />
      </main>
      <Footer />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import Navbar from "@/Components/Web/Navbar.vue"
import Header from "@/Components/Web/Aboutus/Header.vue"
import Content from "@/Components/Web/Aboutus/Content.vue"
import VisiMisi from "@/Components/Web/Aboutus/Visimisi.vue"
import Keunggulan from "@/Components/Web/Aboutus/Keunggulan.vue"
import Gallery from "@/Components/Web/Aboutus/Galerry.vue"
import Footer from "@/Components/Web/Footer.vue"

const loading = ref(true)

onMounted(() => {
  setTimeout(() => {
    loading.value = false
  }, 1000)
})
</script>

<style>
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.animate-fade-in {
  animation: fadeIn 1s ease-in forwards;
}
</style>

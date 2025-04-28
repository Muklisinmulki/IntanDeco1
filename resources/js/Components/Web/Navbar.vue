<template>
  <nav class="bg-white shadow-md py-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center px-6">
      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <img :src="'/images/logo.png'" alt="Logo" class="h-10 w-10" />
        <div class="text-2xl font-medium text-[#1D2D61] font-sans">
          INTAN<span class="text-[#CBA146]"> deco</span>
        </div>
      </div>
      
      <!-- Hamburger Menu (Mobile) -->
      <button @click="toggleMenu" class="md:hidden text-gray-600 text-2xl">
        <i :class="menuOpen ? 'fas fa-times' : 'fas fa-bars'"></i>
      </button>
      
      <!-- Menu -->
      <div
        :class="menuOpen ? 'block' : 'hidden'"
        class="absolute md:relative top-16 left-0 w-full md:w-auto bg-white md:flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6 md:top-0 md:bg-transparent shadow-md md:shadow-none text-center md:text-left py-4 md:py-0 z-50"
      >
      <a
  href="/"
  class="group relative block md:inline-block text-[#1D2D61] hover:text-black px-6 md:px-0 transition duration-300 ease-in-out"
  :class="{'text-[#CBA146] font-bold': currentPath === '/'}"
>
  Home
  <span
    class="absolute left-0 -bottom-1 w-0 h-[2px] bg-[#CBA146] transition-all duration-300 group-hover:w-full"
    :class="{'w-full': currentPath === '/'}"
  ></span>
</a>

<a
  href="/about"
  class="group relative block md:inline-block text-[#1D2D61] hover:text-black px-6 md:px-0 transition duration-300 ease-in-out"
  :class="{'text-[#CBA146] font-bold': currentPath === '/about'}"
>
  About
  <span
    class="absolute left-0 -bottom-1 w-0 h-[2px] bg-[#CBA146] transition-all duration-300 group-hover:w-full"
    :class="{'w-full': currentPath === '/about'}"
  ></span>
</a>

<a
  href="/product"
  class="group relative block md:inline-block text-[#1D2D61] hover:text-black px-6 md:px-0 transition duration-300 ease-in-out"
  :class="{'text-[#CBA146] font-bold': currentPath === '/product'}"
>
  Products
  <span
    class="absolute left-0 -bottom-1 w-0 h-[2px] bg-[#CBA146] transition-all duration-300 group-hover:w-full"
    :class="{'w-full': currentPath === '/product'}"
  ></span>
</a>

<a
  href="/contact"
  class="group relative block md:inline-block text-[#1D2D61] hover:text-black px-6 md:px-0 transition duration-300 ease-in-out"
  :class="{'text-[#CBA146] font-bold': currentPath === '/contact'}"
>
  Contact
  <span
    class="absolute left-0 -bottom-1 w-0 h-[2px] bg-[#CBA146] transition-all duration-300 group-hover:w-full"
    :class="{'w-full': currentPath === '/contact'}"
  ></span>
</a>



        
        <!-- Sosial Media (Mobile) -->
      <div class="flex md:hidden justify-center space-x-4 mt-4">
        <a href="#" class="text-[#1D2D61] hover:text-gray-900 text-xl">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="mailto:youremail@example.com" class="text-[#1D2D61] hover:text-gray-900 text-xl">
          <i class="fas fa-envelope"></i>
        </a>
      </div>
      </div>
      
      <!-- Sosial Media (Desktop) -->
      <div class="hidden md:flex items-center space-x-4">
        <a href="https://www.instagram.com/intan.deco" class="text-[#1D2D61] hover:text-gray-900 text-xl">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="mailto:intangallery1@gmail.com?subject=Judul%20Email&body=Halo%20Admin%2C%0D%0ASaya%20ingin%20bertanya%20tentang..." 
          class="text-[#1D2D61] hover:text-gray-900 text-xl">
          <i class="fas fa-envelope"></i>
        </a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const menuOpen = ref(false)
const currentPath = ref('')

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

onMounted(() => {
  // Get the current path when component mounts
  currentPath.value = window.location.pathname
})
</script>
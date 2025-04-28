<template>
  <footer class="bg-[#1D2D61] text-white py-8 shadow-lg border-t-4 border-gray-200">
    <div class="container mx-auto px-4 text-center space-y-6">
      <!-- Logo INTAN deco putih -->
      <div class="flex items-center justify-center space-x-2">
        <!-- Gambar logo putih -->
        <img :src="'/images/logo2.png'" alt="Logo INTAN deco" class="h-10" />
        <h1 class="text-2xl font-bold tracking-wide">
          INTAN <span class="text-white font-normal">deco</span>
        </h1>
      </div>

      <!-- Navigation -->
      <nav class="flex justify-center gap-6 text-sm">
        <a href="/" class="hover:text-[#CBA146]">Home</a>
        <a href="/about" class="hover:text-[#CBA146]">About</a>
        <a href="/product" class="hover:text-[#CBA146]">Product</a>
        <a href="/contact" class="hover:text-[#CBA146]">Contact</a>
      </nav>

      <!-- Social Media Icons -->
      <div class="flex justify-center gap-6 text-xl">
        <a href="#" class="hover:text-[#CBA146]"><i class="fab fa-instagram"></i></a>
        <a href="mailto:youremail@example.com" class="hover:text-[#CBA146]"><i class="fas fa-envelope"></i></a>
      </div>

      <!-- Copyright -->
      <p class="text-xs text-gray-400">
        © 2025 All rights reserved. 
        <span class="text-[#CBA146] font-semibold">INTAN deco</span>
      </p>
    </div>
  </footer>
</template>
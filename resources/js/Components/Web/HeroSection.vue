<template>
  <div class="relative w-full h-[400px] md:h-[500px] lg:h-[700px]">
    <!-- Background Image with Parallax Effect -->
    <div
      class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-fixed"
      style="background-image: url('/images/bg.png');"
    ></div>

    <!-- Text Overlay -->
    <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-4 md:px-10">
      <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold leading-tight">
        25 Years of Excellence in Handcrafted Home Décor
      </h1>
      <p class="text-sm md:text-lg lg:text-xl mt-2">
        Luxury Stone Décor for Hotels, Villas & Homes
      </p>
      <a href="/product" class="mt-4 bg-white text-black px-4 md:px-6 py-2 md:py-3 rounded-md font-semibold hover:bg-gray-200 transition">
        SHOP NOW
      </a>
    </div>
  </div>
</template>

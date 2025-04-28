<template>
  <div class="relative w-full h-[180px] md:h-[220px] lg:h-[280px]">
    <!-- Background Image with Parallax Effect -->
    <div
      class="absolute inset-0 bg-cover bg-center bg-no-repeat bg-fixed"
      style="background-image: url('/images/bg.png');"
    ></div>

    <!-- Text Overlay -->
    <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center px-2 md:px-10">
      <h1 class="text-lg md:text-2xl lg:text-5xl font-bold leading-tight">
        Contact
      </h1>
      <p class="text-xs md:text-sm lg:text-base mt-1">
        Luxury Stone Décor for Hotels, Villas & Homes
      </p>
    </div>
  </div>
</template>

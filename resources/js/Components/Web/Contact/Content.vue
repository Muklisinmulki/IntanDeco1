<template>
  <section class="bg-white py-10 px-4">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-10">

      <!-- Contact Info -->
      <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Get In Touch</h2>
        <p class="text-gray-600 mb-6">
          Have questions about our products? Drop us a message!
        </p>

        <div class="space-y-4">
          <div class="flex items-start gap-3">
            <i class="fas fa-phone text-[#1D2D61] mt-1"></i>
            <div>
              <p class="text-sm font-semibold text-gray-800">Phone</p>
              <p class="text-sm text-gray-600">085-6011-84892</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <i class="fas fa-envelope text-[#1D2D61] mt-1"></i>
            <div>
              <p class="text-sm font-semibold text-gray-800">Email</p>
              <p class="text-sm text-gray-600">intangallery1@gmail.com</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <i class="fas fa-map-marker-alt text-[#1D2D61] mt-1"></i>
            <div>
              <p class="text-sm font-semibold text-gray-800">Address</p>
              <p class="text-sm text-gray-600">Desa Wisata Kasongan, Bantul, Yogyakarta</p>
            </div>
          </div>

          <div class="flex items-start gap-3">
            <i class="fab fa-instagram text-[#1D2D61] mt-1"></i>
            <div>
              <p class="text-sm font-semibold text-gray-800">Instagram</p>
              <p class="text-sm text-gray-600">@intan.deco</p>
            </div>
          </div>

          <!-- Social Media -->
          <div class="mt-6">
            <p class="text-sm font-semibold text-gray-800 mb-2">Follow Us</p>
            <div class="flex gap-4 text-xl text-gray-600">
              <a href="https://instagram.com/intan.deco" target="_blank" rel="noopener noreferrer" class="hover:text-[#CBA146]">
                <i class="fab fa-instagram"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Google Maps -->
      <div class="h-full">
        <iframe
          class="w-full h-full min-h-[400px] rounded-xl shadow-lg border border-gray-100"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.460030078241!2d110.34365799999999!3d-7.846825999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a56303aef4ca9%3A0x2d64b3c4ffe7c1be!2sIntan%20Gallery!5e0!3m2!1sid!2sid!4v1745546026859!5m2!1sid!2sid"
          allowfullscreen=""
          loading="lazy"
        ></iframe>
      </div>

    </div>
  </section>
</template>

<script setup>
// No scripting needed for now
</script>
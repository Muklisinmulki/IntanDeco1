<template>
  <section class="bg-white py-16" ref="section">
  <div class="max-w-7xl mx-auto px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12">

      <!-- Bagian Gambar Full -->
      <div class="relative">
        <img :src="'/images/about1.jpg'" alt="Interior Design" class="w-full h-full object-cover rounded-lg shadow-lg">
      </div>

      <!-- Kotak Informasi -->
      <div class="relative">
        <!-- Kotak Putih -->
        <div class="bg-white p-8 rounded-lg shadow-lg">
          <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">Welcome to INS</p>
          <h2 class="text-3xl font-bold text-gray-900 leading-snug mb-4">
            Innovative Ideas<br>
            Stylish Designs
          </h2>
          <p class="text-gray-600 mb-6">
            Intan Natural Stone offers handcrafted décor & accessories from premium materials with consistent quality and global trust.
          </p>
          <a href="/about" class="bg-[#CBA146] text-white px-5 py-2 text-sm font-medium rounded hover:bg-gray-800 transition">
            READ MORE
          </a>
        </div>

        <!-- Info Statistik -->
        <div class="mt-8 flex space-x-10">
          <div>
            <p class="text-2xl font-bold text-gray-900">
              <span ref="yearsCounter"></span> +
            </p>
            <p class="text-sm text-gray-500">Years of Experience</p>
          </div>
          <div>
            <p class="text-2xl font-bold text-gray-900">
              <span ref="projectsCounter"></span> +
            </p>
            <p class="text-sm text-gray-500">Projects Completed</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
</template>

<script>
import { CountUp } from 'countup.js';

export default {
  data() {
    return {
      counters: {
        years: null,
        projects: null
      }
    }
  },
  methods: {
    initCounters() {
      // Hancurkan instance sebelumnya jika ada
      if (this.counters.years) this.counters.years.reset();
      if (this.counters.projects) this.counters.projects.reset();
      
      // Buat instance baru
      this.counters.years = new CountUp(this.$refs.yearsCounter, 25, {
        duration: 2,
        separator: ','
      });
      
      this.counters.projects = new CountUp(this.$refs.projectsCounter, 1250, {
        duration: 2,
        separator: ','
      });
      
      // Mulai animasi
      this.counters.years.start();
      this.counters.projects.start();
    }
  },
  mounted() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.initCounters();
        }
      });
    }, {
      threshold: 0.5
    });

    observer.observe(this.$refs.section);
    
    // Simpan observer instance untuk dibersihkan nanti
    this.observer = observer;
  },
  beforeUnmount() {
    // Bersihkan observer ketika komponen di-unmount
    if (this.observer) {
      this.observer.disconnect();
    }
  }
}
</script>
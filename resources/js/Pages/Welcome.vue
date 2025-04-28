<template>
  <div>
    <!-- Loading Spinner -->
    <div
      v-if="loading"
      class="fixed inset-0 z-50 flex items-center justify-center bg-white"
    >
      <div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
    </div>

    <!-- Main Content -->
    <div v-else class="animate-fade-in">
      <Navbar />
      <HeroSection />

      <!-- AboutUs Section -->
      <section class="bg-white py-16" ref="counterSection">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-12">
            <!-- Image -->
            <div class="relative">
              <img src="/images/about1.jpg" alt="Interior Design" class="w-full h-full object-cover rounded-lg shadow-lg" />
            </div>

            <!-- Information -->
            <div class="relative">
              <div class="bg-white p-8 rounded-lg shadow-lg">
                <p class="text-sm text-gray-500 uppercase tracking-wide mb-2">Welcome to INS</p>
                <h2 class="text-3xl font-bold text-gray-900 leading-snug mb-4">
                  Innovative Ideas<br />
                  Stylish Designs
                </h2>
                <p class="text-gray-600 mb-6">
                  Intan Natural Stone offers handcrafted décor & accessories from premium materials with consistent quality and global trust.
                </p>
                <a href="/about" class="bg-[#CBA146] text-white px-5 py-2 text-sm font-medium rounded hover:bg-gray-800 transition">
                  READ MORE
                </a>
              </div>

              <div class="mt-8 flex space-x-10">
                <div>
                  <p class="text-2xl font-bold text-gray-900">
                    <span ref="yearsCounterElement">0</span> +
                  </p>
                  <p class="text-sm text-gray-500">Years of Experience</p>
                </div>
                <div>
                  <p class="text-2xl font-bold text-gray-900">
                    <span ref="productsCounterElement">0</span> +
                  </p>
                  <p class="text-sm text-gray-500">Products Available</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Catalog Section -->
      <main class="container mx-auto p-6">
        <div class="flex flex-col items-center text-center mb-8">
          <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-900">Our Product Catalog</h1>
            <p class="text-lg text-gray-600">Browse through our collection</p>
          </div>
          <a 
            href="/product" 
            class="bg-[#CBA146] text-white px-5 py-2 text-sm font-medium rounded hover:bg-gray-800 transition"
            @click="loadMoreProducts"
          >
            View More
          </a>
        </div>

        <div v-if="catalogs.length > 0" class="catalog-container">
          <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            <div 
              v-for="catalog in catalogs" 
              :key="catalog.id" 
              class="catalog-item bg-white rounded-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full"
            >
              <div class="image-container cursor-zoom-in aspect-square overflow-hidden" @click="showLightbox(catalog)">
                <img 
                  :src="'/storage/' + catalog.image" 
                  :alt="catalog.name" 
                  class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                />
              </div>
              <div class="p-2 sm:p-3 md:p-4 flex-grow">
                <h3 class="text-xs sm:text-sm md:text-base font-medium text-gray-900 mb-1 line-clamp-2">{{ catalog.name }}</h3>
                <p class="text-xs text-gray-500">{{ catalog.category.name }}</p>
                <p class="text-[10px] text-gray-400">Code: {{ catalog.code }}</p>
              </div>
            </div>
          </div>

          <vue-easy-lightbox
            :visible="visible"
            :imgs="imgs"
            :index="index"
            @hide="handleHide"
          ></vue-easy-lightbox>
        </div>
      </main>

      <Footer />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from 'vue'
import axios from 'axios'
import VueEasyLightbox from 'vue-easy-lightbox'
import Navbar from "@/Components/Web/Navbar.vue"
import HeroSection from "@/Components/Web/HeroSection.vue"
import Footer from "@/Components/Web/Footer.vue"
import { CountUp } from 'countup.js'

// Data Refs
const loading = ref(true)
const catalogs = ref([])
const categories = ref([])
const totalProducts = ref(0)
const counterSection = ref(null)
const yearsCounterElement = ref(null)
const productsCounterElement = ref(null)
const lastId = ref(0)

// Counter instances
const yearsCounter = ref(null)
const productsCounter = ref(null)

// Lightbox
const visible = ref(false)
const imgs = ref([])
const index = ref(0)

// Lightbox functions
const showLightbox = (catalog) => {
  index.value = 0
  imgs.value = [`/storage/${catalog.image}`]
  visible.value = true
}

const handleHide = () => {
  visible.value = false
}

// Load more products function
const loadMoreProducts = async () => {
  try {
    const response = await axios.get('/api/catalogs', {
      params: {
        limit: catalogs.value.length + 8
      }
    })
    catalogs.value = response.data.catalogs
  } catch (error) {
    console.error('Error loading more products:', error)
  }
}

// Initialize or reset counters
const animateCounters = () => {
  // Reset elements to 0
  if (yearsCounterElement.value) yearsCounterElement.value.textContent = '0'
  if (productsCounterElement.value) productsCounterElement.value.textContent = '0'
  
  // Years counter (static value)
  if (yearsCounterElement.value) {
    try {
      if (yearsCounter.value) {
        yearsCounter.value.reset()
        yearsCounter.value.update(25)
      } else {
        yearsCounter.value = new CountUp(yearsCounterElement.value, 25, {
          duration: 2.5,
          separator: ',',
        })
        yearsCounter.value.start()
      }
    } catch (e) {
      console.error("Years counter error:", e)
    }
  }

  // Products counter (dynamic value)
  if (productsCounterElement.value && totalProducts.value > 0) {
    try {
      if (productsCounter.value) {
        productsCounter.value.reset()
        productsCounter.value.update(totalProducts.value)
      } else {
        productsCounter.value = new CountUp(productsCounterElement.value, totalProducts.value, {
          duration: 2.5,
          separator: ',',
        })
        productsCounter.value.start()
      }
    } catch (e) {
      console.error("Products counter error:", e)
    }
  }
}

// Set up intersection observer for counters
const setupCounterIntersectionObserver = () => {
  if (!counterSection.value) return

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Delay animation slightly for better visual effect
        setTimeout(animateCounters, 1000)
      } else {
        // Reset to 0 when leaving view
        if (yearsCounterElement.value) yearsCounterElement.value.textContent = '0'
        if (productsCounterElement.value) productsCounterElement.value.textContent = '0'
      }
    })
  }, { 
    threshold: 0.5,
    rootMargin: '0px 0px -50px 0px' // Triggers slightly before center
  })

  observer.observe(counterSection.value)
}

// Watch for changes in totalProducts
watch(totalProducts, (newValue) => {
  if (newValue > 0 && productsCounterElement.value) {
    // Reset before animating to new value
    productsCounterElement.value.textContent = '0'
    
    nextTick(() => {
      if (productsCounter.value) {
        productsCounter.value.reset()
        productsCounter.value.update(newValue)
      } else {
        productsCounter.value = new CountUp(productsCounterElement.value, newValue, {
          duration: 2.5,
          separator: ',',
        })
        productsCounter.value.start()
      }
    })
  }
})

// Load total products count
const loadTotalProducts = async () => {
  try {
    const response = await axios.get('/api/catalogstotal')
    totalProducts.value = response.data.totalProducts || 0
  } catch (error) {
    console.error('Error fetching total products:', error)
    totalProducts.value = 0
  }
}

// Load catalog data
const loadCatalogs = async () => {
  try {
    const response = await axios.get('/api/catalogs')
    catalogs.value = response.data.catalogs || []
    categories.value = response.data.categories || []
    
    // Simpan ID terakhir
    if (catalogs.value.length > 0) {
      lastId.value = Math.max(...catalogs.value.map(c => c.id))
    }
  } catch (error) {
    console.error('Error fetching catalogs:', error)
  }
}


onMounted(async () => {
  try {
    // Load essential data first
    await Promise.all([loadTotalProducts(), loadCatalogs()])

    loading.value = false

    // Setup intersection observer after DOM is ready
    nextTick(() => {
      setupCounterIntersectionObserver()
    })
  } catch (error) {
    console.error('Error initializing component:', error)
    loading.value = false
  }
})
const checkForUpdates = async () => {
  try {
    const response = await axios.get('/api/check-updates', {
      params: { last_id: lastId.value }
    })
    
    // Jika ada produk baru
    if (response.data.new_catalogs.length > 0) {
      // Tambahkan ke awal array
      catalogs.value.unshift(...response.data.new_catalogs)
      lastId.value = response.data.last_id
    }
    
    // Update total produk jika berubah
    if (totalProducts.value !== response.data.total_products) {
      totalProducts.value = response.data.total_products
    }
  } catch (error) {
    console.error('Error checking updates:', error)
  }
}
onMounted(async () => {
  try {
    loading.value = true
    await Promise.all([loadTotalProducts(), loadCatalogs()])
    
    // Setup intersection observer
    nextTick(() => {
      setupCounterIntersectionObserver()
    })
    
    // Mulai polling untuk update
    const interval = setInterval(checkForUpdates, 1000) // 15 detik
    
    // Bersihkan interval saat komponen di-unmount
    onUnmounted(() => clearInterval(interval))
  } catch (error) {
    console.error('Error initializing component:', error)
  } finally {
    loading.value = false
  }
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
.catalog-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}
.catalog-item {
  transition: all 0.3s ease;
  border: 1px solid #e5e7eb;
}
.catalog-item:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
              0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.image-container {
  overflow: hidden;
}
.image-container img {
  transition: transform 0.3s ease;
}
.image-container:hover img {
  transform: scale(1.03);
}
.cursor-zoom-in {
  cursor: zoom-in;
}
</style>
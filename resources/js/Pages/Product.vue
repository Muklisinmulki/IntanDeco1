<template>
  <div>
    <!-- Loading Spinner -->
    <div
      v-if="loading"
      class="fixed inset-0 z-50 flex items-center justify-center bg-white"
    >
      <div class="w-12 h-12 border-4 border-blue-500 border-dashed rounded-full animate-spin"></div>
    </div>

    <div v-else class="animate-fade-in">
      <Navbar />
      <Header />
      <main class="container mx-auto p-4 sm:p-6">
        <div class="flex flex-col md:flex-row gap-4 sm:gap-6">
          <!-- Tombol toggle kategori untuk mobile -->
          <button 
            @click="showMobileCategories = !showMobileCategories"
            class="md:hidden flex items-center justify-between p-3 bg-white rounded-lg shadow-sm border border-gray-200 mb-2"
          >
            <span class="font-medium text-gray-700">Categories</span>
            <svg 
              class="w-5 h-5 text-gray-500 transition-transform duration-200" 
              :class="{'rotate-180': showMobileCategories}"
              fill="none" 
              viewBox="0 0 24 24" 
              stroke="currentColor"
            >
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Sidebar Kategori (Kiri) - Tersembunyi di mobile kecuali di-toggle -->
          <div 
            class="w-full lg:w-72 xl:w-80 transition-all duration-300 ease-in-out"
            :class="{
              'block': showMobileCategories,
              'hidden md:block': !showMobileCategories
            }"
          >
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-md md:sticky md:top-6 border border-gray-100">
              <div class="flex items-center justify-between mb-4 sm:mb-6">
                <h1 class="text-lg sm:text-xl font-bold text-gray-800">Categories</h1>
                <button 
                  @click="resetFilter"
                  class="flex items-center text-xs font-medium text-[#1D2D61] hover:text-[#CBA146] transition-colors"
                >
                  <svg 
                    class="w-4 h-4 mr-1" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                  >
                    <path 
                      stroke-linecap="round" 
                      stroke-linejoin="round" 
                      stroke-width="2" 
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                    />
                  </svg>
                  Reset
                </button>
              </div>
              
              <!-- Scrollable categories container -->
              <div class="max-h-[calc(100vh-180px)] overflow-y-auto pr-2 -mr-2">
                <div v-if="categories.length">
                  <div 
                    v-for="category in categories" 
                    :key="category.id"
                    @click="filterByCategory(category.id)"
                    :class="[
                      'flex items-center px-3 sm:px-4 py-2 sm:py-3 mb-2 rounded-lg cursor-pointer transition-all',
                      'hover:bg-gray-100 hover:text-[#1D2D61]',
                      activeCategory === category.id 
                        ? 'bg-gray-100 text-[#1D2D61] font-medium border-l-4 border-[#CBA146]' 
                        : 'text-[#1D2D61]'
                    ]"
                  >
                    <span class="ml-2 text-sm sm:text-base">{{ category.name }}</span>
                    <span 
                      v-if="activeCategory === category.id"
                      class="ml-auto text-xs bg-[#CBA146] text-white px-2 py-1 rounded-full"
                    >
                      {{ catalogs.filter(c => c.category.id === category.id).length }}
                    </span>
                  </div>
                </div>
                <div v-else class="space-y-3">
                  <div v-for="i in 5" :key="i" class="h-8 bg-gray-100 rounded animate-pulse"></div>
                </div>
              </div>
            </div>
          </div>

          <!-- Daftar Produk (Kanan) -->
          <div class="w-full md:w-3/4 lg:w-4/5">
            <!-- Search Bar -->
            <div class="mb-4 sm:mb-6">
              <div class="relative">
                <input
                  v-model="searchQuery"
                  type="text"
                  placeholder="Search products by name, category, or code..."
                  class="w-full p-3 pl-10 pr-4 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#CBA146] focus:border-transparent"
                  @keyup.enter="handleSearch"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                  </svg>
                </div>
                <button 
                  v-if="searchQuery" 
                  @click="clearSearch"
                  class="absolute inset-y-0 right-0 pr-3 flex items-center"
                >
                  <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
            </div>

            <div v-if="filteredCatalogs.length > 0" class="catalog-container">
              <!-- Grid produk - 2 kolom di mobile, 3 di tablet, 4 di desktop -->
              <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4 lg:gap-6">
                <div 
                  v-for="catalog in filteredCatalogs" 
                  :key="catalog.id" 
                  class="catalog-item bg-white rounded-md overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full"
                >
                  <div class="image-container cursor-zoom-in aspect-square overflow-hidden" @click="showLightbox(catalog)">
                    <img 
                      :src="'/storage/' + catalog.image" 
                      :alt="catalog.name" 
                      class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                      loading="lazy"
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
            <div v-else class="text-center py-10">
              <p class="text-gray-500">No products found {{ searchQuery ? 'matching your search' : 'in this category' }}</p>
              <button 
                v-if="searchQuery" 
                @click="clearSearch"
                class="mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium"
              >
                Clear search
              </button>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import VueEasyLightbox from 'vue-easy-lightbox'
import Navbar from "@/Components/Web/Navbar.vue"
import Header from "@/Components/Web/Product/Header.vue"
import Footer from "@/Components/Web/Footer.vue"

// Reactive state
const loading = ref(true)
const catalogs = ref([])
const categories = ref([])
const activeCategory = ref(null)
const showMobileCategories = ref(false)
const searchQuery = ref('')
const visible = ref(false)
const imgs = ref([])
const index = ref(0)

// Computed property untuk produk yang difilter
const filteredCatalogs = computed(() => {
  let filtered = catalogs.value
  
  // Filter berdasarkan kategori yang aktif
  if (activeCategory.value) {
    filtered = filtered.filter(catalog => catalog.category.id === activeCategory.value)
  }
  
  // Filter berdasarkan search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase()
    filtered = filtered.filter(catalog => {
      // Cek di beberapa field sekaligus
      return (
        catalog.name.toLowerCase().includes(query) || 
        (catalog.category && catalog.category.name.toLowerCase().includes(query)) || 
        (catalog.code && catalog.code.toLowerCase().includes(query)) || 
        (catalog.description && catalog.description.toLowerCase().includes(query))
      )
    })
  }
  
  return filtered
})

// Methods
const filterByCategory = (categoryId) => {
  activeCategory.value = categoryId
  searchQuery.value = ''
  if (window.innerWidth < 768) showMobileCategories.value = false
}

const resetFilter = () => {
  activeCategory.value = null
  searchQuery.value = ''
}

const clearSearch = () => {
  searchQuery.value = ''
}

const handleSearch = () => {
  // Tidak perlu melakukan apa-2 karena computed property sudah otomatis update
  console.log('Searching for:', searchQuery.value)
}

const showLightbox = (catalog) => {
  imgs.value = ['/storage/' + catalog.image]
  index.value = 0
  visible.value = true
}

const handleHide = () => {
  visible.value = false
}

// Lifecycle
onMounted(async () => {
  setTimeout(() => (loading.value = false), 1000)
  try {
    const response = await axios.get('/api/catalogsfull')
    catalogs.value = response.data.catalogs
    categories.value = response.data.categories
  } catch (error) {
    console.error('Error fetching catalogs:', error)
  }
})
</script>
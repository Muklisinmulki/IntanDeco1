<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import Chart from 'chart.js/auto';
import { Line } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement
} from 'chart.js'
import axios from 'axios'

// Register ChartJS components
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  CategoryScale,
  LinearScale,
  PointElement
)

// Data dan fungsi untuk chart
const pieChart = ref(null);
const chartData = ref([]);
const lineChartData = ref(null);
const loading = ref(true);
let chart = null;

// Data dan fungsi untuk kalender
const events = ref([]);
const currentDate = ref(new Date());
const currentMonth = ref(currentDate.value.getMonth());
const currentYear = ref(currentDate.value.getFullYear());
const showImageModal = ref(false);
const selectedCatalogs = ref([]);
const selectedDate = ref('');
const categoryCount = ref(0);
const todayCatalogsCount = ref(0);


// Computed properties
const totalProducts = computed(() => {
  return chartData.value.reduce((total, item) => total + item.total, 0);
});

const monthNames = [
  'January', 'February', 'March', 'April', 'May', 'June',
  'July', 'August', 'September', 'October', 'November', 'December'
];

const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// Chart options for line chart
const lineChartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    },
    title: {
      display: true,
      text: 'Upload Catalog Harian'
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      ticks: {
        precision: 0
      }
    }
  }
};

// Fungsi untuk generate warna chart
const getRandomColors = (count) => {
  const colors = [];
  const baseHue = 40;
  const hueRange = 30;
  const minSaturation = 50;
  const maxSaturation = 70;
  const minLightness = 45;
  const maxLightness = 65;

  for (let i = 0; i < count; i++) {
    const hue = (baseHue + (i * 25) - (count * 12.5)) % 360;
    const adjustedHue = ((hue + 180) % 360 + baseHue - hueRange/2) % 360 + hueRange/2;
    const saturation = minSaturation + (i % (maxSaturation - minSaturation + 1));
    const lightness = minLightness + ((i * 7) % (maxLightness - minLightness + 1));
    colors.push(`hsl(${adjustedHue}, ${saturation}%, ${lightness}%)`);
  }
  
  return colors;
};

// Fungsi untuk mengambil data chart
const fetchCatalogData = async () => {
  try {
    const response = await fetch('/api/catalog-by-category');
    const data = await response.json();
    chartData.value = data;
    renderChart(data);
  } catch (error) {
    console.error('Error fetching catalog data:', error);
  } finally {
    loading.value = false;
  }
};

// Fungsi untuk mengambil data line chart
const fetchLineChartData = async () => {
  try {
    const response = await fetch('/dashboard/catalog-chart');
    const data = await response.json();
    
    lineChartData.value = {
      labels: data.map(item => item.date),
      datasets: [
        {
          label: 'Jumlah Upload',
          data: data.map(item => item.total),
          fill: false,
          borderColor: '#3b82f6',
          backgroundColor: '#3b82f6',
          tension: 0.1
        }
      ]
    };
  } catch (error) {
    console.error('Error fetching line chart data:', error);
  }
};

// Fungsi untuk render chart
const renderChart = (data) => {
  if (!pieChart.value) return;
  
  const ctx = pieChart.value.getContext('2d');
  
  if (chart) {
    chart.destroy();
  }
  
  const labels = data.map(item => item.name);
  const values = data.map(item => item.total);
  const backgroundColors = getRandomColors(data.length);
  
  chart = new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labels,
      datasets: [{
        data: values,
        backgroundColor: backgroundColors,
        borderColor: 'white',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            boxWidth: 15
          }
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              const label = context.label || '';
              const value = context.raw || 0;
              const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
              const percentage = Math.round((value / total) * 100);
              return `${label}: ${value} item (${percentage}%)`;
            }
          }
        }
      }
    }
  });
};

// Fungsi untuk mengambil data event kalender
const fetchCatalogEvents = async () => {
  try {
    const response = await fetch('/api/catalogs-by-date');
    const data = await response.json();
    // Group by date and keep the latest image
    const groupedByDate = {};
    data.forEach(event => {
      if (!groupedByDate[event.date]) {
        groupedByDate[event.date] = {
          count: 0,
          latestImage: null,
          catalogs: []
        };
      }
      groupedByDate[event.date].count++;
      groupedByDate[event.date].catalogs.push(event);
      if (event.image && !groupedByDate[event.date].latestImage) {
        groupedByDate[event.date].latestImage = event.image;
      }
    });
    
    // Format for display
    events.value = Object.keys(groupedByDate).map(date => {
      return {
        date,
        count: groupedByDate[date].count,
        image: groupedByDate[date].latestImage,
        catalogs: groupedByDate[date].catalogs,
        color: 'bg-blue-500'
      };
    });
  } catch (error) {
    console.error('Error fetching catalog events:', error);
  }
};

// Fungsi untuk mengambil jumlah katalog hari ini
const fetchTodayCatalogsCount = async () => {
  try {
    const response = await axios.get('/today-catalogs-count');
    todayCatalogsCount.value = response.data.count;
  } catch (error) {
    console.error("Gagal mengambil data katalog hari ini", error);
  }
};

// Fungsi kalender
const daysInMonth = (month, year) => {
  return new Date(year, month + 1, 0).getDate();
};

const firstDayOfMonth = (month, year) => {
  return new Date(year, month, 1).getDay();
};

const prevMonth = () => {
  if (currentMonth.value === 0) {
    currentMonth.value = 11;
    currentYear.value--;
  } else {
    currentMonth.value--;
  }
};

const nextMonth = () => {
  if (currentMonth.value === 11) {
    currentMonth.value = 0;
    currentYear.value++;
  } else {
    currentMonth.value++;
  }
};

const getEventsForDay = (day) => {
  const dateStr = `${currentYear.value}-${String(currentMonth.value + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
  return events.value.filter(event => event.date === dateStr);
};

const openImageModal = (date) => {
  const eventsForDate = events.value.find(event => event.date === date);
  if (eventsForDate) {
    selectedCatalogs.value = eventsForDate.catalogs;
    selectedDate.value = date;
    showImageModal.value = true;
  }
};

// Format tanggal untuk display
const formatDate = (dateStr) => {
  const date = new Date(dateStr);
  return date.toLocaleDateString('id-ID', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  });
};

// Lifecycle hook
onMounted(() => {
  fetchTodayCatalogsCount();
  fetchCatalogData();
  fetchCatalogEvents();
  fetchLineChartData();
});
onMounted(async () => {
  try {
    const response = await axios.get('/dashboard/category-count')
    categoryCount.value = response.data.count
  } catch (error) {
    console.error("Gagal mengambil data kategori", error)
  }
})
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
  <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900">

        <!-- Card Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <!-- Card Jumlah Kategori -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h2 class="text-lg font-medium text-gray-500">Jumlah Kategori</h2>
                  <p class="text-3xl font-bold text-gray-800 mt-2">{{ categoryCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                  </svg>
                </div>
              </div>
              <div class="mt-4">
                <span class="text-sm text-blue-600 font-medium">↑ 5% dari bulan lalu</span>
              </div>
            </div>
          </div>

          <!-- Card Jumlah Produk -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h2 class="text-lg font-medium text-gray-500">Jumlah Produk</h2>
                  <p class="text-3xl font-bold text-gray-800 mt-2">{{ totalProducts }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                  </svg>
                </div>
              </div>
              <div class="mt-4">
                <span class="text-sm text-green-600 font-medium">↑ 12% dari bulan lalu</span>
              </div>
            </div>
          </div>

          <!-- Card Produk Hari Ini -->
          <div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
            <div class="p-6">
              <div class="flex items-center justify-between">
                <div>
                  <h2 class="text-lg font-medium text-gray-500">Produk Hari Ini</h2>
                  <p class="text-3xl font-bold text-gray-800 mt-2">{{ todayCatalogsCount }}</p>
                </div>
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
              <div class="mt-4">
                <span class="text-sm text-orange-600 font-medium" v-if="todayCatalogsCount > 0">↑ {{ Math.round((todayCatalogsCount/totalProducts)*100) }}% dari total</span>
                <span class="text-sm text-gray-500 font-medium" v-else>Belum ada produk hari ini</span>
              </div>
            </div>
          </div>
        </div>

        <!-- First Row: Pie Chart and Calendar -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
           <!-- Pie Chart Section - Diperbesar -->
          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Katalog Berdasarkan Kategori</h2>
            <div class="h-[500px] relative">  <!-- Tinggi diperbesar dari h-80 ke h-[400px] -->
              <canvas 
                ref="pieChart" 
                class="w-full h-full"  
              ></canvas>
            </div>
          </div>
          
          <!-- Calendar Section -->
          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h3 class="text-xl font-semibold mb-4">Kalender Upload Katalog</h3>
            
            <!-- Calendar Component -->
            <div class="border border-gray-200 rounded-lg overflow-hidden">
              <!-- Calendar Header -->
              <div class="flex items-center justify-between bg-gray-50 px-4 py-3 border-b border-gray-200">
                <button 
                  @click="prevMonth"
                  class="p-1 rounded-full hover:bg-gray-100"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                  </svg>
                </button>
                <h3 class="text-lg font-medium text-gray-700">
                  {{ monthNames[currentMonth] }} {{ currentYear }}
                </h3>
                <button 
                  @click="nextMonth"
                  class="p-1 rounded-full hover:bg-gray-100"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                  </svg>
                </button>
              </div>
              
              <!-- Days of Week -->
              <div class="grid grid-cols-7 bg-gray-50 border-b border-gray-200">
                <div 
                  v-for="day in dayNames" 
                  :key="day"
                  class="py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  {{ day }}
                </div>
              </div>
              
              <!-- Calendar Days -->
              <div class="grid grid-cols-7 divide-x divide-y divide-gray-200">
                <!-- Empty cells for days before the first of the month -->
                <div 
                  v-for="n in firstDayOfMonth(currentMonth, currentYear)" 
                  :key="'empty-' + n"
                  class="h-24 bg-gray-50"
                ></div>
                
                <!-- Actual days of the month -->
                <div 
                  v-for="day in daysInMonth(currentMonth, currentYear)" 
                  :key="day"
                  class="h-24 p-1 border border-gray-100 hover:bg-gray-50 transition-colors"
                  :class="{
                    'bg-blue-50': new Date().getDate() === day && 
                                new Date().getMonth() === currentMonth && 
                                new Date().getFullYear() === currentYear
                  }"
                >
                  <div class="flex justify-between items-start">
                    <span 
                      class="text-sm font-medium px-1"
                      :class="{
                        'text-blue-600 bg-blue-100 rounded-full w-6 h-6 flex items-center justify-center': 
                          new Date().getDate() === day && 
                          new Date().getMonth() === currentMonth && 
                          new Date().getFullYear() === currentYear
                      }"
                    >
                      {{ day }}
                    </span>
                  </div>
                  
                  <!-- Events for the day -->
                  <div class="mt-1">
                    <div 
                      v-for="event in getEventsForDay(day)" 
                      :key="event.date"
                      class="cursor-pointer"
                      @click="openImageModal(event.date)"
                    >
                      <div class="relative">
                        <div v-if="event.image" class="w-12 h-12 rounded-full overflow-hidden mb-1 mx-auto border-2 border-white shadow">
                          <img 
                            :src="event.image" 
                            alt="Latest Catalog" 
                            class="w-full h-full object-cover"
                          >
                        </div>
                        <div 
                          v-if="event.count > 0"
                          class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
                        >
                          {{ event.count }}
                        </div>
                      </div>
                      <div 
                        v-if="!event.image"
                        class="text-xs p-1 rounded truncate flex items-center hover:opacity-90 bg-blue-500 text-white"
                      >
                        <span class="truncate">{{ event.count }} produk</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Second Row: Statistics and Line Chart -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
          <!-- Statistics Section -->
          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold">Statistik Katalog</h2>
              <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                Total: {{ totalProducts }} produk
              </span>
            </div>
            <div class="relative">
              <div v-if="loading" class="py-4 text-center text-gray-500">
                <svg class="animate-spin h-5 w-5 mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
              </div>
              <div v-else class="overflow-y-auto max-h-64 pr-2 scrollbar">
                <div v-for="(item, index) in chartData" :key="index" class="flex justify-between p-2 border-b last:border-b-0">
                  <span class="font-medium">{{ item.name }}</span>
                  <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm">
                    {{ item.total }} item
                  </span>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Line Chart Section -->
          <div class="bg-gray-50 p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Grafik Upload Harian</h2>
            <div class="h-80 relative">
              <Line 
                v-if="lineChartData" 
                :data="lineChartData" 
                :options="lineChartOptions" 
              />
              <div v-else class="flex items-center justify-center h-full text-gray-500">
                Memuat data grafik...
              </div>
            </div>
          </div>
        </div>

        <!-- Image Modal -->
        <div v-if="showImageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
          <div class="bg-white rounded-lg p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4 sticky top-0 bg-white py-2">
              <h3 class="text-lg font-semibold">Katalog pada {{ formatDate(selectedDate) }}</h3>
              <button @click="showImageModal = false" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div 
                v-for="(catalog, index) in selectedCatalogs" 
                :key="index"
                class="border rounded-lg p-4 hover:shadow-md transition-shadow"
              >
                <div class="flex items-start">
                  <div v-if="catalog.image" class="w-24 h-24 rounded overflow-hidden mr-4 flex-shrink-0">
                    <img 
                      :src="catalog.image" 
                      alt="Catalog Image" 
                      class="w-full h-full object-cover"
                    >
                  </div>
                  <div>
                    <h4 class="font-medium text-gray-900">{{ catalog.title }}</h4>
                    <p class="text-sm text-gray-600 mb-1">Kode: {{ catalog.code }}</p>
                    <p class="text-sm text-gray-600">Kategori: {{ catalog.category }}</p>
                    <p class="text-xs text-gray-500 mt-2">Diupload: {{ catalog.created_at }}</p>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="mt-6 flex justify-end sticky bottom-0 bg-white py-2">
              <button 
                @click="showImageModal = false" 
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
              >
                Tutup
              </button>
            </div>
          </div>
        </div>

        <div class="border-t border-gray-200 pt-6">
          Selamat datang di dashboard manajemen katalog!
        </div>
      </div>
    </div>
  </div>
</div>
  </AuthenticatedLayout>
</template>

<style scoped>
.scrollbar::-webkit-scrollbar {
  width: 6px;
}

.scrollbar::-webkit-scrollbar-track {
  background: #f1f1f1;
  border-radius: 8px;
}

.scrollbar::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 8px;
}

.scrollbar::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

.scrollbar {
  scrollbar-width: thin;
  scrollbar-color: #cbd5e1 #f1f1f1;
}

/* Animasi modal */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}
</style>
<template>
  <aside class="h-full w-20 md:w-64 bg-gray-900 text-white flex flex-col justify-between px-2 py-4">
   <!-- Top Navigation -->
   <nav class="space-y-6">
  <a href="/dashboard" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-800">
    <i class="fas fa-tachometer-alt w-5"></i>
    <span class="hidden md:inline">Dashboard</span>
  </a>
  <a href="/admin_settings" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-800">
    <i class="fas fa-cogs w-5"></i>
    <span class="hidden md:inline">Admin Configuration</span>
  </a>
  <a href="/produk" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-800">
    <i class="fas fa-boxes w-5"></i>
    <span class="hidden md:inline">Product Management</span>
  </a>
  <a href="/settingss" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-800">
    <i class="fas fa-sliders-h w-5"></i>
    <span class="hidden md:inline">Website Settings</span>
  </a>
  <a href="/analisis" class="flex items-center space-x-2 px-4 py-2 rounded hover:bg-gray-800">
    <i class="fas fa-chart-line w-5"></i>
    <span class="hidden md:inline">Analytics</span>
  </a>
</nav>



    <!-- Logout -->
    <div class="pt-6 border-t border-gray-700">
      <SidebarItem icon="fa-sign-out-alt" label="Logout" @click="showLogoutCard = true" />
    </div>

    <!-- Modal Logout -->
    <LogoutModal
      :show="showLogoutCard"
      @cancel="showLogoutCard = false"
      @confirm="handleLogout"
    />
  </aside>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import SidebarItem from '@/Components/Web/SidebarItem.vue';
import LogoutModal from '@/Components/Web/LogoutModal.vue';

export default {
  name: 'Sidebar',
  components: {
    SidebarItem,
    LogoutModal
  },
  data() {
    return {
      showLogoutCard: false
    };
  },
  methods: {
    handleLogout() {
      this.showLogoutCard = false;
      Inertia.get('/admin'); // Ganti '/admin' sesuai route logout kamu
    }
  }
};
</script>

<template>
  <nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16 items-center">
        <!-- Left side - Brand -->
        <div class="flex items-center space-x-4">
          <div class="flex items-center space-x-2">
            <img   alt="Admin Logo" class="h-8 w-auto" />
            <span class="text-lg font-bold text-gray-800">
              INTAN<span class="text-[#CBA146]">Admin</span>
            </span>
          </div>
        </div>

        <!-- Right side -->
        <div class="flex items-center space-x-6">
          <!-- Quick Access Icons -->
          <div class="hidden md:flex items-center space-x-4">
            <button class="p-2 rounded-full hover:bg-gray-100 relative" title="Notifications">
              <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m4 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
              <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full px-1">3</span>
            </button>
            <button class="p-2 rounded-full hover:bg-gray-100" title="Messages">
              <svg class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </button>
          </div>

          <!-- Admin Profile -->
          <div class="relative" ref="userMenu">
            <button @click="toggleUserMenu" class="flex items-center space-x-2 focus:outline-none">
              <div class="h-8 w-8 rounded-full bg-[#CBA146] flex items-center justify-center">
                <span class="text-white font-medium">A</span>
              </div>
              <span class="hidden md:inline text-sm font-medium text-gray-700">Admin</span>
              <svg class="h-4 w-4 text-gray-500 transform transition-transform duration-200"
                :class="{ 'rotate-180': showUserMenu }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <transition name="dropdown">
              <div v-if="showUserMenu"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">User Management</a>
                <div class="border-t border-gray-200"></div>
                <button
                  @click="showLogoutModal = true"
                  class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
                >
                  Logout
                </button>
              </div>
            </transition>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Modal Logout -->
  <LogoutModal
    :show="showLogoutModal"
    @cancel="showLogoutModal = false"
    @confirm="logout"
  />
</template>

<script>
import LogoutModal from '@/Components/Web/Dashboard/LogoutModal.vue'
import { Inertia } from '@inertiajs/inertia'

export default {
  name: 'AdminNavbar',
  components: {
    LogoutModal
  },
  data() {
    return {
      showUserMenu: false,
      showLogoutModal: false
    }
  },
  mounted() {
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    toggleUserMenu() {
      this.showUserMenu = !this.showUserMenu
    },
    logout() {
      this.showLogoutModal = false
      Inertia.get('/login')
    },
    handleClickOutside(e) {
      if (this.showUserMenu && this.$refs.userMenu && !this.$refs.userMenu.contains(e.target)) {
        this.showUserMenu = false
      }
    }
  }
}
</script>

<style scoped>
/* Dropdown transition animation */
.dropdown-enter-active,
.dropdown-leave-active {
  transition: all 0.2s ease;
}
.dropdown-enter-from,
.dropdown-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>

<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import Logout from '@/Components/Web/LogoutModal.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const showingNavigationDropdown = ref(false);
const sidebarOpen = ref(true);
const sidebarCollapsed = ref(false);
const showLogoutModal = ref(false);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div class="flex flex-col h-screen bg-gray-100">
        <!-- Navbar at the top -->
        <nav class="bg-white border-b border-gray-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        
                        <div class="flex items-center">
                            <Link :href="route('dashboard')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="relative ml-3">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 hover:text-gray-700 focus:outline-none"
                                        >
                                            {{ $page.props.auth.user.name }}

                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink :href="route('profile.edit')">
                                        Profile
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        Log Out
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex': !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex': showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="sm:hidden"
            >
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Dashboard
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('products.index')"
                        :active="route().current('products.index')"
                    >
                        Products
                    </ResponsiveNavLink>
                     <ResponsiveNavLink
                        :href="route('catalog.index')"
                        :active="route().current('catalog.index')"
                    >
                        Catalog
                    </ResponsiveNavLink>
                </div>

                <div class="border-t border-gray-200 pb-1 pt-4">
                    <div class="px-4">
                        <div class="text-base font-medium text-gray-800">
                            {{ $page.props.auth.user.name }}
                        </div>
                        <div class="text-sm font-medium text-gray-500">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            Profile
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        
        <!-- Main Content Area with Sidebar -->
        <div class="flex flex-1 overflow-hidden relative">
            <!-- Sidebar -->
            <aside 
                class="bg-gray-800 text-white transition-all duration-300 ease-in-out flex-shrink-0 relative"
                :class="[
                    sidebarOpen ? 'w-64' : '-ml-64',
                    sidebarCollapsed ? '!w-20' : ''
                ]"
            >
                <!-- Collapse button - now positioned inside sidebar but sticking to the edge -->
                <button 
                    @click="toggleSidebar"
                    class="absolute -right-3 top-5 z-10 p-1.5 rounded-full bg-gray-800 border-2 border-gray-600 text-white hover:bg-gray-700 transition-all shadow-md"
                    title="Toggle sidebar"
                >
                    <svg 
                        class="w-4 h-4 transition-transform duration-300"
                        :class="{ 'rotate-180': sidebarCollapsed }"
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <div class="flex flex-col h-full">
                    <nav class="p-4 space-y-2 flex-1 overflow-y-auto">
                        <Link 
                            :href="route('dashboard')" 
                            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': route().current('dashboard'), 'justify-center': sidebarCollapsed }"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span :class="{ 'hidden': sidebarCollapsed, 'group-hover:inline-block': sidebarCollapsed, 'absolute left-16 ml-2 px-2 py-1 bg-gray-800 rounded text-sm whitespace-nowrap': sidebarCollapsed }">Dashboard</span>
                        </Link>

                        <!-- Catalog -->
                        <Link 
                            :href="route('catalog.index')" 
                            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': route().current('catalog.index'), 'justify-center': sidebarCollapsed }"
                        >
                            <!-- Shopping Bag Icon -->
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V9a4 4 0 10-8 0v2M5 11h14l-1 9H6l-1-9z" />
                            </svg>
                            <span :class="{ 'hidden': sidebarCollapsed, 'group-hover:inline-block': sidebarCollapsed, 'absolute left-16 ml-2 px-2 py-1 bg-gray-800 rounded text-sm whitespace-nowrap': sidebarCollapsed }">Catalog</span>
                        </Link>

                        <!-- Categories -->
                        <Link 
                            :href="route('categories.index')" 
                            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': route().current('categories.index'), 'justify-center': sidebarCollapsed }"
                        >
                            <!-- Collection Icon -->
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2h-3.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0010.586 5H8a2 2 0 00-2 2v2" />
                            </svg>
                            <span :class="{ 'hidden': sidebarCollapsed, 'group-hover:inline-block': sidebarCollapsed, 'absolute left-16 ml-2 px-2 py-1 bg-gray-800 rounded text-sm whitespace-nowrap': sidebarCollapsed }">Categories</span>
                        </Link>
                        


                        <Link 
                            :href="route('profile.edit')" 
                            class="flex items-center space-x-3 px-4 py-2 rounded hover:bg-gray-700 group"
                            :class="{ 'bg-gray-700': route().current('profile.edit'), 'justify-center': sidebarCollapsed }"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span :class="{ 'hidden': sidebarCollapsed, 'group-hover:inline-block': sidebarCollapsed, 'absolute left-16 ml-2 px-2 py-1 bg-gray-800 rounded text-sm whitespace-nowrap': sidebarCollapsed }">Profile</span>
                        </Link>
                    </nav>

                    <div class="p-4 border-t border-gray-700">
                        <button 
                            @click="showLogoutModal = true"
                            class="flex items-center space-x-3 w-full px-4 py-2 rounded hover:bg-gray-700 text-red-400 hover:text-red-300 group"
                            :class="{ 'justify-center': sidebarCollapsed }"
                        >
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span :class="{ 'hidden': sidebarCollapsed, 'group-hover:inline-block': sidebarCollapsed, 'absolute left-16 ml-2 px-2 py-1 bg-gray-800 rounded text-sm whitespace-nowrap': sidebarCollapsed }">Logout</span>
                        </button>
                    </div>
                </div>
            </aside>

          <!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <!-- Header yang lebih lebar -->
    <header class="bg-white shadow" v-if="$slots.header">
        <div class="mx-auto w-full px-4 py-6 sm:px-6">  <!-- Hapus max-w constraint -->
            <div class="flex items-center justify-between">
                <slot name="header" />
            </div>
        </div>
    </header>

    <!-- Konten Utama yang Lebih Luas -->
    <main class="flex-1 overflow-y-auto">
        <div class="w-full p-0">  <!-- Hapus padding atau sesuaikan -->
            <slot />
        </div>
    </main>
</div>
        </div>

        <!-- Enhanced Logout Modal -->
<div v-if="showLogoutModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4 border border-gray-100 shadow-2xl transform transition-all duration-300 scale-95 hover:scale-100">
        <div class="flex flex-col items-center text-center">
            <!-- Icon -->
            <div class="mb-4 p-3 bg-red-50 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Ready to leave?</h3>
            <p class="text-sm text-gray-500 mb-6 max-w-xs">You'll need to sign in again to access your account.</p>
            
            <div class="flex justify-center space-x-3 w-full">
                <button 
                    @click="showLogoutModal = false"
                    class="px-5 py-2 text-sm font-medium text-gray-600 bg-white rounded-lg hover:bg-gray-50 border border-gray-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Stay logged in
                </button>
                <button 
                    @click="logout"
                    class="px-5 py-2 text-sm font-medium text-white bg-gradient-to-br from-red-500 to-red-600 rounded-lg hover:from-red-600 hover:to-red-700 shadow-sm transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    Yes, logout
                </button>
            </div>
        </div>
    </div>
</div>
    </div>
</template>
<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import VueEasyLightbox from 'vue-easy-lightbox';

const props = defineProps({
    catalogs: Array,
    categories: Array,
    filters: Object
});

// Lightbox state
const visible = ref(false);
const imgUrl = ref('');

const showImg = (imageUrl) => {
    imgUrl.value = '/storage/' + imageUrl;
    visible.value = true;
};

const deleteCatalog = (id) => {
    if (confirm('Are you sure you want to delete this catalog?')) {
        router.delete(route('catalog.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                // Optional: Show success message or perform other actions
            },
            onError: () => {
                alert('Failed to delete catalog');
            }
        });
    }
};

const search = ref(props.filters?.search || '')

const searchCatalogs = () => {
  router.get(route('catalog.index'), { search: search.value }, {
    preserveState: true,
    replace: true,
  })
}
</script>

<template>
    <Head title="Catalogs" />
    <Layout>
        <!-- Vue Easy Lightbox -->
        <VueEasyLightbox
            :visible="visible"
            :imgs="imgUrl"
            @hide="visible = false"
        />

        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    <div class="p-8">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">Product Catalogs</h1>
                                <p class="text-gray-500 mt-1">Manage your product listings and inventory</p>
                            </div>
                            <Link 
                                :href="route('catalog.create')" 
                                class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-5 py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-md hover:shadow-lg"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Create New Catalog
                            </Link>
                        </div>
                        <!-- Search Form -->
                        <div class="mb-6">
                            <form @submit.prevent="searchCatalogs" class="max-w-md">
                                <div class="relative">
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search catalogs..."
                                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                                />
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                </div>
                            </form>
                        </div>

                        <div class="overflow-x-auto rounded-xl border border-gray-100 shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <div class="flex items-center">
                                                Category
                                                <a :href="route('categories.index')"  class="ml-2 text-gray-400 hover:text-gray-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                        <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="catalog in catalogs" :key="catalog.id" class="hover:bg-gray-50 transition-colors">
                                        <!-- Kolom Nama (diperlebar) -->
                                        <td class="px-4 py-3 w-[300px] min-w-[300px] max-w-[300px]">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 mr-3">
                                                    <img 
                                                        v-if="catalog.image" 
                                                        :src="'/storage/' + catalog.image" 
                                                        class="h-10 w-10 rounded-md object-cover cursor-pointer"
                                                        @click="showImg(catalog.image)"
                                                    >
                                                    <div v-else class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="text-sm font-medium text-gray-900 break-words whitespace-normal">
                                                        {{ catalog.name }}
                                                    </div>
                                                    <div class="text-xs font-medium text-gray-500 break-words whitespace-normal">
                                                        {{ catalog.code }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">ID: {{ catalog.id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Kolom Kategori (dipersempit) -->
                                        <td class="px-4 py-3 whitespace-nowrap w-[150px] min-w-[150px]">
                                            <div class="text-sm text-gray-900">
                                                <span class="inline-flex px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                    {{ catalog.category?.name || 'Uncategorized' }}
                                                </span>
                                            </div>
                                        </td>
                                        
                                        <!-- Kolom Gambar (dipersempit) -->
                                        <td class="px-4 py-3 whitespace-nowrap w-[120px] min-w-[120px]">
                                            <button 
                                                v-if="catalog.image"
                                                @click="showImg(catalog.image)" 
                                                class="inline-flex items-center px-2.5 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                            >
                                                View
                                            </button>
                                            <span v-else class="text-sm text-gray-400">No image</span>
                                        </td>
                                        
                                        <!-- Kolom Aksi (tetap sama) -->
                                        <td class="px-4 py-3 whitespace-nowrap text-right w-[150px] min-w-[150px]">
                                            <div class="flex justify-end space-x-2">
                                                <Link 
                                                    :href="route('catalog.edit', catalog.id)" 
                                                    class="text-blue-600 hover:text-blue-900 flex items-center gap-1 text-sm"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </Link>
                                                <button 
                                                    @click="deleteCatalog(catalog.id)" 
                                                    class="text-red-600 hover:text-red-900 flex items-center gap-1 text-sm"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <tr v-if="catalogs.length === 0">
                                        <td colspan="4" class="px-6 py-8 text-center">
                                            <div class="flex flex-col items-center justify-center text-gray-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                                <h3 class="text-lg font-medium">No catalogs found</h3>
                                                <p class="mt-1">Get started by creating a new catalog</p>
                                                <Link 
                                                    :href="route('catalog.create')" 
                                                    class="mt-4 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                                >
                                                    Create Catalog
                                                </Link>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination would go here if needed -->
                        <div class="mt-6 flex items-center justify-between">
                            <div class="text-sm text-gray-500">
                                Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">20</span> results
                            </div>
                            <div class="flex space-x-2">
                                <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </button>
                                <button class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
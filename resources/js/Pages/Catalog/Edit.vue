<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    catalog: Object,
    categories: Array
});

const form = useForm({
    name: props.catalog.name,
    code: props.catalog.code, // Ditambahkan karena ada field code di form
    category_id: props.catalog.category_id,
    image: null,
    _method: 'PUT' // Important for update requests
});

const submit = () => {
    form.post(route('catalog.update', props.catalog.id), {
        onSuccess: () => form.reset('image'),
        preserveScroll: true,
        forceFormData: true // Important for file uploads
    });
};
</script>

<template>
    <Head :title="`Edit ${catalog.name}`" />
    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-6">Edit Catalog</h1>
                    
                    <form @submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Catalog Name</label>
                            <input v-model="form.name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Catalog Code</label>
                            <input v-model="form.code" type="text" id="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <p v-if="form.errors.code" class="text-red-500 text-sm mt-1">{{ form.errors.code }}</p>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select v-model="form.category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select a category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <p v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Current Image</label>
                            <img v-if="catalog.image" :src="'/storage/' + catalog.image" class="h-20 w-20 object-cover rounded mt-2 border">
                            <span v-else class="text-gray-500">No image</span>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">New Image (Leave empty to keep current)</label>
                            <input @input="form.image = $event.target.files[0]" type="file" id="image" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-md file:border-0
                              file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700
                              hover:file:bg-blue-100">
                            <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</p>
                        </div>

                        <div class="flex space-x-4 pt-4">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" :disabled="form.processing">
                                <span v-if="form.processing">Updating...</span>
                                <span v-else>Update Catalog</span>
                            </button>
                            <Link :href="route('catalog.index')" class="inline-flex justify-center rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </Layout>
</template>
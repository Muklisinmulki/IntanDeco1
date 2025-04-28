<!-- Catalog/Create.vue -->
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    categories: Array
});

const form = useForm({
    name: '',
    code: '',
    category_id: '',
    image: null,
});

const submit = () => {
    form.post(route('catalog.store'));
};
</script>

<template>
    <Head title="Create Catalog" />
    <Layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h1 class="text-2xl font-bold mb-6">Create Catalog</h1>
                    
                    <form @submit.prevent="submit" class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Catalog Name</label>
                            <input v-model="form.name" type="text" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <p v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</p>
                        </div>

                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700">Catalog Code</label>
                            <input v-model="form.code" type="text" id="code" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <p v-if="form.errors.code" class="text-red-500 text-sm mt-1">{{ form.errors.code }}</p>
                        </div>

                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                            <select v-model="form.category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select a category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                            </select>
                            <p v-if="form.errors.category_id" class="text-red-500 text-sm mt-1">{{ form.errors.category_id }}</p>
                        </div>

                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700">Catalog Image</label>
                            <input @input="form.image = $event.target.files[0]" type="file" id="image" class="mt-1 block w-full">
                            <p v-if="form.errors.image" class="text-red-500 text-sm mt-1">{{ form.errors.image }}</p>
                        </div>

                        <div class="flex space-x-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" :disabled="form.processing">
                                Create Catalog
                            </button>
                            <Link :href="route('catalog.index')" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                                Cancel
                            </Link>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </Layout>
</template>
<template>
    <Modal>
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-lg font-semibold text-gray-900">
                    Create New Product
                </h3>
                <Link :href="route('products.index')"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
                </Link>
            </div>
            <!-- Modal body -->
            <form class="p-4" @submit.prevent="handleProductCreation">
                <div class="flex flex-col mb-6">
                    <div class="grid gap-4 grid-cols-2 mb-4">
                        <div class="col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-semibold text-gray-900">Name</label>
                            <input type="text" name="name" id="name" v-model="form.name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="Type product name" required>
                            <InputError :message="form.errors.name" />
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="price"
                                class="block mb-2 text-sm font-semibold text-gray-900">Price</label>
                            <input type="number" name="price" id="price" v-model="form.price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                placeholder="$2999" required>
                            <InputError :message="form.errors.price" />

                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="category"
                                class="block mb-2 text-sm font-semibold text-gray-900">Category</label>
                            <select id="category" v-model="form.category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="" selected>Select category</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{
                                    category.name }}</option>
                            </select>
                            <InputError :message="form.errors.category_id" />
                        </div>
                        <div class="col-span-2">
                            <label for="description"
                                class="block mb-2 text-sm font-semibold text-gray-900">Product
                                Description</label>
                            <textarea id="description" rows="4" v-model="form.description"
                                class="resize-none block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Write product description here"></textarea>
                            <InputError :message="form.errors.description" />
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="-mb-2 text-sm font-semibold text-gray-900">Product images</div>
                        <div class="flex w-full space-x-4 overflow-x-scroll pt-4">
                            <div class="flex items-center justify-start flex-shrink-0">
                                <label for="dropzone-file"
                                    class="flex items-center justify-center w-32 h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <svg class="w-12 h-12" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        viewBox="0 0 24 24">
                                        <path fill="#999"
                                            d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h8q.425 0 .713.288T14 4q0 .425-.288.713T13 5H5v14h14v-8q0-.425.288-.712T20 10q.425 0 .713.288T21 11v8q0 .825-.587 1.413T19 21zM17 7h-1q-.425 0-.712-.288T15 6q0-.425.288-.712T16 5h1V4q0-.425.288-.712T18 3q.425 0 .713.288T19 4v1h1q.425 0 .713.288T21 6q0 .425-.288.713T20 7h-1v1q0 .425-.288.713T18 9q-.425 0-.712-.288T17 8zm-5.75 9L9.4 13.525q-.15-.2-.4-.2t-.4.2l-2 2.675q-.2.25-.05.525T7 17h10q.3 0 .45-.275t-.05-.525l-2.75-3.675q-.15-.2-.4-.2t-.4.2zm.75-4" />
                                    </svg>
                                    <input id="dropzone-file" type="file" accept="image/png, image/jpeg, image/jpg" class="hidden" @change="handleFileChange"
                                        multiple />
                                </label>
                            </div>
                            <div class="relative flex-shrink-0" v-for="(image, index) in selectedImages" :key="index">
                                <img :src="image.preview" alt="Uploaded Image"
                                    class="w-32 h-32 rounded-lg object-contain" />
                                <button type="button"
                                    class="absolute -top-3 -right-3 bg-gray-200 p-1.5 rounded-full shadow-gray-500 shadow-xl"
                                    @click="removeImage(image)">
                                    <svg class="w-2.5 h-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <InputError :message="form.errors.images" />
                    </div>
                </div>
                <button type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-5 py-2.5 text-center">
                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Add new product
                </button>
            </form>
        </div>
    </Modal>
</template>
<script setup>
import { ref } from 'vue';
import Modal from '@/Components/Modal.vue';
import { Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import { useProducts } from '@/Composables/useProducts';

defineProps({
    categories: Array
});

const selectedImages = ref([]);

const form = useForm({
    name: 'pppppppp',
    description: 'pppppp',
    price: 44,
    category_id: 2,
    images: new FormData()
});

const { createProduct } = useProducts();

function handleFileChange(event) {
    const images = Array.from(event.target.files)
        .filter(file => file.type.startsWith('image/'))
        .map(
            file => (
                {
                    file,
                    preview: URL.createObjectURL(file),
                }
            )
        );

    selectedImages.value.push(...images);
}

function removeImage(image) {
    selectedImages.value = selectedImages.value.filter(img => img !== image)
}

function handleProductCreation() {
    form.images = selectedImages.value.map(image => image.file);
    createProduct(form);
}


</script>
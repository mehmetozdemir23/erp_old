<template>
    <AppHead title="`Product ${product.sku}`" />
    <AuthenticatedLayout>
        <Modal>
            <div class="flex justify-between mb-4 rounded-t sm:mb-5">
                <div class="text-lg text-gray-900 md:text-xl">
                    <h3 class="font-semibold mb-1">
                        {{ product.name }}
                    </h3>
                    <p class="font-bold">
                        ${{ product.price }}
                    </p>
                </div>
                <div>
                    <Link :href="route('products.index')"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                    </Link>
                </div>
            </div>
            <dl>
                <dt class="mb-2 font-semibold leading-none text-gray-900">Details</dt>
                <dd class="mb-4 font-light text-gray-500 sm:mb-5">
                    {{ product.description }}
                </dd>
            </dl>
            <div class="flex justify-between items-center">
                <Link :href="route('products.edit', { product })"
                    class="text-white inline-flex items-center font-semibold bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-semibold rounded-lg text-sm px-4 py-2 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="w-4 h-4 mr-1">
                    <path fill="currentColor"
                        d="M3 21v-4.25L17.625 2.175L21.8 6.45L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                </svg>
                Edit
                </Link>
                <Link :href="route('products.confirm-delete', { product })"
                    class="text-red-600 inline-flex items-center font-semibold hover:text-white border border-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-semibold rounded-lg text-sm px-4 py-2 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                    class="w-4 h-4 mr-1 fill-red-500">
                    <path fill="currentColor"
                        d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                </svg>
                Delete
                </Link>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
<script setup>
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import AppHead from '@/Components/AppHead.vue';
defineProps({
    product: {
        type: Object,
        required: true
    }
});
</script>
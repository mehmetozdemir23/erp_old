<template>
    <div>
        <!-- Sidebar -->
        <aside :class="isVisible ? 'translate-x-0 shadow-gray-400' : '-translate-x-full shadow-white bg-white'"
            class="fixed top-0 left-0 z-30 w-60 h-screen pt-14 shadow-md bg-white transition-transform border-r border-gray-200 lg:translate-x-0 lg:bg-white lg:shadow-none">
            <!-- Sidebar content -->
            <div class="overflow-y-auto py-5 px-3 h-full">
                <ul class="space-y-2">
                    <li>
                        <a href="#"
                            class="flex items-center p-2 text-base font-semibold text-gray-900 rounded-lg hover:bg-gray-100 group">
                            <svg aria-hidden="true"
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                                <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                            </svg>
                            <span class="ml-3">Overview</span>
                        </a>
                    </li>
                    <li>
                        <Link :href="route('products.index')"
                            class="flex items-center p-2 text-base font-semibold text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg aria-hidden="true"
                            class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                        <span class="ml-3">Products</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Overlay for the remaining space -->
        <div v-show="isVisible" @click="closeSidebar" class="fixed top-0 left-0 z-20 w-full h-full bg-black opacity-30">
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    isVisible: Boolean
});

const emit = defineEmits(['closed']);

function closeSidebar() {
    emit('closed');
}
</script>
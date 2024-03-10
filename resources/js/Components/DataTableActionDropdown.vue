<template>
    <div
        class="shadow-md absolute bottom-0 right-0 rounded-md translate-y-full z-10 w-max bg-white rounded divide-y divide-gray-100">
        <ul class="py-1 text-sm">

            <li>
                <Link v-if="can('product.update')" :href="route('products.edit', { product })"
                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="w-4 h-4 mr-2">
                    <path fill="currentColor"
                        d="M3 21v-4.25L17.625 2.175L21.8 6.45L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                </svg>
                Edit
                </Link>
            </li>
            <li>
                <Link v-if="can('products.view')" :href="route('products.show', { product })"
                    class="flex w-full items-center py-2 px-4 hover:bg-gray-100 text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48" class="w-4 h-4 mr-2">
                    <defs>
                        <mask id="ipSPreviewOpen0">
                            <g fill="none" stroke-linejoin="round" stroke-width="4">
                                <path fill="#fff" stroke="#fff"
                                    d="M24 36c11.046 0 20-12 20-12s-8.954-12-20-12S4 24 4 24s8.954 12 20 12Z" />
                                <path fill="#000" stroke="#000" d="M24 29a5 5 0 1 0 0-10a5 5 0 0 0 0 10Z" />
                            </g>
                        </mask>
                    </defs>
                    <path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipSPreviewOpen0)" />
                </svg>
                Preview
                </Link>
            </li>
            <li>
                <Link v-if="can('product.delete')" :href="route('products.confirm-delete', { product })" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 text-red-500
                       ">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                    class="w-4 h-4 mr-2 fill-red-500">
                    <path fill="currentColor"
                        d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                </svg>
                Delete
                </Link>
            </li>
        </ul>
    </div>
</template>
<script setup>
defineProps({
    actions: {
        type: Array,
        required: true
    }
});
</script>
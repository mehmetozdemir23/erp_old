<template>
    <AppHead title="Products" />
    <AuthenticatedLayout>
        <Alert :message="page.props.flash.message" />
        <section class="bg-gray-50 p-3 sm:p-5 antialiased">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <div class="bg-white relative shadow-md sm:rounded-lg overflow-hidden">
                    <ProductTable :products="products.data" :products-count="productsCount" :links="products.links"
                        :total-sales="totalSales" :selected-sort-column="selectedSortColumn"
                        :selected-sort-order="selectedSortOrder" :filters="filters" :selected-filters="selectedFilters"
                        :search="search" />
                </div>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AppHead from '@/Components/AppHead.vue';
import ProductTable from '@/Pages/Products/Partials/Table.vue';
import Alert from '@/Components/Alert.vue';

import { usePage } from '@inertiajs/vue3';

defineProps({
    products: Object,
    productsCount: Number,
    totalSales: String,
    selectedSortColumn: String,
    selectedSortOrder: String,
    filters: Object,
    selectedFilters: Object,
    search: String
});

const page = usePage();

</script>
<template>
    <div class="relative overflow-hidden bg-white shadow-md sm:rounded-lg">
        <div
            class="flex flex-col px-4 py-3 space-y-3 sm:flex-row sm:items-center sm:justify-between sm:space-y-0 sm:space-x-4">
            <div class="flex items-center flex-1 space-x-4">
                <h5 class="flex flex-col lg:flex-row">
                    <span class="text-gray-500">All Products: </span>
                    <span class="dark:text-white">{{ productsCount }}</span>
                </h5>
                <h5 class="flex flex-col lg:flex-row">
                    <span class="text-gray-500">Total sales: </span>
                    <span class="dark:text-white">${{ totalSales }}</span>
                </h5>
            </div>
            <div
                class="flex flex-col flex-shrink-0 space-y-3 sm:flex-row md:items-center sm:justify-end sm:space-y-0 sm:space-x-3">
                <button type="button" v-if="selectedProducts.length"
                    class="flex items-center px-3 py-2 text-sm font-semibold text-red-700 rounded-lg bg-red-50 hover:border hover:border-red-700 focus:ring-4 focus:ring-red-300 focus:outline-none"
                    @click="deleteProducts">
                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6zM8 9h8v10H8zm7.5-5l-1-1h-5l-1 1H5v2h14V4z" />
                    </svg>
                    Delete
                    <span
                        class="flex items-center justify-center ml-2 w-5 h-5 rounded-full text-xs text-white bg-red-700 hover:bg-red-800">
                        {{ selectedProducts.length }}
                    </span>
                </button>
                <Link v-if="can('product.create')" :href="route('products.create')"
                    class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 focus:outline-none">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M11 13H5v-2h6V5h2v6h6v2h-6v6h-2z" />
                </svg>
                Add new product
                </Link>
                <a :href="route('products.export')"
                    class="flex items-center justify-center flex-shrink-0 px-3 py-2 text-sm font-semibold text-gray-900 bg-white border border-gray-200 rounded-lg focus:outline-none hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                        viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="M8.71 7.71L11 5.41V15a1 1 0 0 0 2 0V5.41l2.29 2.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42l-4-4a1 1 0 0 0-.33-.21a1 1 0 0 0-.76 0a1 1 0 0 0-.33.21l-4 4a1 1 0 1 0 1.42 1.42M21 14a1 1 0 0 0-1 1v4a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-4a1 1 0 0 0-2 0v4a3 3 0 0 0 3 3h14a3 3 0 0 0 3-3v-4a1 1 0 0 0-1-1" />
                    </svg>
                    Export
                </a>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-between items-center lg:space-x-2 space-x-0 pl-2 pr-4 py-3">
            <label for="product-search" class="sr-only">Search products</label>
            <div class="relative w-full max-w-md">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewbox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="product-search" v-model="searchInput"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2"
                    placeholder="Search products" required>
            </div>
            <ul class="my-2 flex flex-col space-y-2 sm:flex-row w-full max-w-md sm:space-x-4 sm:space-y-0">
                <li v-for="(options, column) in filters" :key="column" class="w-full">
                    <ProductFilter :options="options" :selectedFilter="selectedFilters[column]" :column="column"
                        @filter-changed="updateFilter(column, $event)" />
                </li>
            </ul>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all" type="checkbox" @change="selectAllProducts(products)"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 focus:ring-2"
                                    :checked="allProductsSelected">
                                <label for="checkbox-all" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <TableColumn name="product" :is-current-sort="isSelectedSortColumn('products.name')"
                            @sort="sortBy('products.name')" />
                        <TableColumn name="category" :is-current-sort="isSelectedSortColumn('category.name')"
                            @sort="sortBy('category.name')" />
                        <TableColumn name="stock" :is-current-sort="isSelectedSortColumn('stock')"
                            @sort="sortBy('stock')" />
                        <TableColumn name="price" :is-current-sort="isSelectedSortColumn('price')"
                            @sort="sortBy('price')" />
                        <TableColumn name="sales" :is-current-sort="isSelectedSortColumn('sales')"
                            @sort="sortBy('sales')" />
                        <TableColumn name="revenue" :is-current-sort="isSelectedSortColumn('revenue')"
                            @sort="sortBy('revenue')" />
                        <TableColumn name="last update" :is-current-sort="isSelectedSortColumn('products.updated_at')"
                            @sort="sortBy('products.updated_at')" />
                    </tr>
                </thead>
                <tbody v-if="products.length">
                    <tr v-for="product in products" :key="product.id" class="border-b hover:bg-gray-100 group">
                        <td class="w-4 px-4 py-3">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" onclick="event.stopPropagation()"
                                    class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500 focus:ring-2"
                                    @change="selectProduct(product)" :checked="selectedProducts.includes(product)">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="w-max flex items-center px-4 py-2 font-semibold text-gray-900 whitespace-nowrap">
                            <img :src="product.thumbnail" alt="Product thumbnail" class="w-8 h-8 object-contain mr-3">
                            {{ product.name }}
                        </th>
                        <td class="px-4 py-2">
                            <span class="w-max bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">{{
                        product.category.name }}</span>
                        </td>
                        <td class="px-4 py-2 font-semibold text-gray-900 whitespace-nowrap">
                            {{ product.stock.quantity }}
                        </td>
                        <td class="px-4 py-2 font-semibold text-gray-900 whitespace-nowrap">
                            ${{ product.price }}
                        </td>
                        <td class="px-4 py-2 font-semibold text-gray-900 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5 mr-2 text-gray-400" aria-hidden="true">
                                    <path
                                        d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                    </path>
                                </svg>
                                <span class="font-semibold text-[0.9rem]">
                                    {{ product.sales_count }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-2">${{ (product.price * product.sales_count).toFixed(2) }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900 whitespace-nowrap">{{ product.updated_at }}
                        </td>
                        <td class="px-4 py-2 opacity-0 group-hover:opacity-100">
                            <Link :href="route('products.edit', { product })">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M3 21v-4.25L16.2 3.575q.3-.275.663-.425t.762-.15q.4 0 .775.15t.65.45L20.425 5q.3.275.438.65T21 6.4q0 .4-.137.763t-.438.662L7.25 21zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                            </svg>
                            </Link>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="12">
                            <div class="flex items-center justify-center px-4 py-8">
                                <svg class="h-6 mr-2" xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                    viewBox="0 0 256 256">
                                    <path fill="currentColor"
                                        d="M128 24a104 104 0 1 0 104 104A104.11 104.11 0 0 0 128 24m0 192a88 88 0 1 1 88-88a88.1 88.1 0 0 1-88 88m-8-80V80a8 8 0 0 1 16 0v56a8 8 0 0 1-16 0m20 36a12 12 0 1 1-12-12a12 12 0 0 1 12 12" />
                                </svg>
                                No products found
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <nav class="flex flex-col items-start justify-between p-4 space-y-3 md:flex-row md:items-center md:space-y-0"
            aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500">
                Showing
                <span class="font-semibold text-gray-900">1-10</span>
                of
                <span class="font-semibold text-gray-900">1000</span>
            </span>
            <Pagination :links="links" />
        </nav>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import TableColumn from '@/Pages/Products/Partials/TableColumn.vue';
import ProductFilter from '@/Pages/Products/Partials/Filter.vue';

import { useProductsSearch } from '@/Composables/useProductsSearch';
import { useProductsFilter } from '@/Composables/useProductsFilter';
import { useProducts } from '@/Composables/useProducts';
import { useProductsSort } from '@/Composables/useProductsSort';

const props = defineProps({
    products: Array,
    productsCount: Number,
    totalSales: String,
    links: Object,
    selectedSortColumn: String,
    selectedSortOrder: String,
    filters: Object,
    selectedFilters: Object,
    search: String
});

const { searchInput } = useProductsSearch(props.search);

const { filters, selectedFilters, updateFilter } = useProductsFilter(props.filters, props.selectedFilters);

const { selectedProducts, allProductsSelected, selectProduct, selectAllProducts, deleteProducts } = useProducts();

const { isSelectedSortColumn, sortBy } = useProductsSort(props.selectedSortColumn, props.selectedSortOrder);


</script>
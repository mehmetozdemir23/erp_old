import { ref, watch, onMounted } from "vue";
import { router } from "@inertiajs/vue3";

export function useProductsFilter(initialFilters, initialSelectedFilters) {
    const filters = {};

    const selectedFilters = ref({
        ...initialSelectedFilters,
    });

    initFilters();

    watch(selectedFilters, applyFilters, { deep: true });

    function initFilters() {
        for (const [column, options] of Object.entries(initialFilters)) {
            filters[column] = options;
        }
    }

    function updateFilter(column, filter) {
        selectedFilters.value[column] = filter;
    }

    function applyFilters() {
        router.get(
            route("products.index", {
                ...route().params,
                filters: selectedFilters.value,
            }),
            {
                preserveScroll: true,
            }
        );
    }

    return { filters, selectedFilters, updateFilter };
}

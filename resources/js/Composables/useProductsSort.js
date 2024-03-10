import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

export function useProductsSort(initialSortColumn, initialSortOrder) {
    const selectedSortColumn = ref(initialSortColumn);
    const selectedSortOrder = ref(initialSortOrder);

    function isSelectedSortColumn(column) {
        return selectedSortColumn.value === column;
    }
    function sortBy(column) {
        selectedSortOrder.value =
            selectedSortColumn.value === column
                ? selectedSortOrder.value === "asc"
                    ? "desc"
                    : "asc"
                : "asc";
        selectedSortColumn.value = column;
        router.get(
            route("products.index"),
            {
                ...route().params,
                sort_column: selectedSortColumn.value,
                sort_order: selectedSortOrder.value,
            },
            { preserveScroll: true }
        );
    }

    return {
        selectedSortColumn,
        selectedSortOrder,
        isSelectedSortColumn,
        sortBy,
    };
}

import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

export function useProductsSearch(initialSearchInput) {
    const searchInput = ref(initialSearchInput);

    watch(searchInput, () => {
        setTimeout(performProductSearch, 300);
    });

    function performProductSearch() {
        router.get(
            route("products.index"),
            {
                ...route().params,
                search: searchInput.value,
            },
            { preserveState: true }
        );
    }

    return {
        searchInput,
    };
}

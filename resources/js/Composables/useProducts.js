import { ref, watch } from "vue";
import { router } from "@inertiajs/vue3";

export function useProducts() {
    const selectedProducts = ref([]);

    const allProductsSelected = ref(false);

    function selectProduct(product) {
        const index = selectedProducts.value.indexOf(product);

        if (index !== -1) {
            selectedProducts.value.splice(index, 1);
        } else {
            selectedProducts.value.push(product);
        }
    }

    function selectAllProducts(products) {
        selectedProducts.value = allProductsSelected.value ? [] : products;
        allProductsSelected.value = !allProductsSelected.value;
    }

    function createProduct(form) {
        router.post(route("products.store"), form, {
            onError: (errors) => {
                form.errors = errors;
            },
        });
    }

    function updateProduct(product, form) {
        const newImages = form.newImages.map((image) => image.file);

        router.post(
            route("products.update", product),
            {
                ...form.data(),
                newImages,
                _method: "put",
            },
            {
                onError: (errors) => {
                    form.errors = errors;
                },
            }
        );
    }

    function deleteProducts() {
        router.delete(
            route("products.destroyMany", {
                products: selectedProducts.value.map((product) => product.id),
            })
        );
        selectedProducts.value = [];
        allProductsSelected.value = false;
    }

    return {
        selectedProducts,
        allProductsSelected,
        selectProduct,
        selectAllProducts,
        createProduct,
        updateProduct,
        deleteProducts,
    };
}

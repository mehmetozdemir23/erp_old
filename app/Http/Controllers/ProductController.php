<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Sale;
use App\Services\ProductExportService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(public ProductService $productService, public ProductExportService $productExportService)
    {
    }

    public function export()
    {
        return $this->productExportService->exportToExcel('test-file');
    }

    public function index(Request $request)
    {
        $this->authorize('product.viewAny');

        $validatedData = $request->validate([
            'sort_column' => ['nullable', 'string', 'in:products.name,category.name,stock,sales,price,revenue,products.updated_at'],
            'sort_order' => ['nullable', 'in:asc,desc'],
            'search' => ['nullable', 'string'],
            'filters' => ['nullable', 'array'],
        ]);

        $sortColumn = $validatedData['sort_column'] ?? 'products.created_at';
        $sortOrder = $validatedData['sort_order'] ?? 'desc';
        $search = $validatedData['search'] ?? '';
        $filters = $validatedData['filters'] ?? [];

        [$products, $updatedFilters] = $this->productService->getProductsForIndex($sortColumn, $sortOrder, $search, $filters);

        return inertia('Products/Index', [
            'products' => $products,
            'productsCount' => Product::count(),
            'totalSales' => Sale::sum('total_amount'),
            'selectedSortColumn' => $sortColumn,
            'selectedSortOrder' => $sortOrder,
            'filters' => $updatedFilters,
            'selectedFilters' => $filters,
            'search' => $search,
        ]);

    }

    public function create()
    {
        $this->authorize('product.create');

        return inertia('Products/Create', [
            'categories' => ProductCategory::get(['id', 'name']),
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $validatedData = $request->validated();

        $this->productService->storeProduct($validatedData);

        return to_route('products.index')->with('message', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        $this->authorize('product.view');

        return inertia('Products/Show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorize('product.update');

        $product->setAttribute('base64Images', $product->base64Images());

        return inertia('Products/Edit', [
            'product' => $product,
            'categories' => ProductCategory::get(['id', 'name']),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productService->updateProduct($product, $request->validated());

        return to_route('products.index');
    }

    public function confirmDelete(Product $product)
    {
        return inertia('Products/Delete', compact('product'));
    }

    public function destroyMany($products)
    {
        $this->authorize('product.delete');

        $productIds = explode(',', $products);

        $this->productService->deleteProducts($productIds);

        return to_route('products.index')->with('message', 'Product deleted successfully!');
    }
}

<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    public function __construct(public ProductIndexService $productIndexService)
    {

    }

    public function getProductsForIndex(
        $sortColumn,
        $sortOrder,
        $search,
        $filters
    ) {
        return $this->productIndexService->getProducts(
            $sortColumn,
            $sortOrder,
            $search,
            $filters
        );
    }

    public function storeProduct(array $attributes)
    {
        $product = new Product($attributes);

        $category = ProductCategory::find($attributes['category_id']);

        $product->category()->associate($category);

        $product->save();

        $product->stock()->save(new ProductStock());

        $productImages = $attributes['images'];
        foreach ($productImages as $key => $image) {
            $imageModel = new ProductImage(['path' => basename($image->storeAs("product_images/$product->id", Str::random(10).'.'.$image->extension()))]);
            $product->images()->save($imageModel);
        }
    }

    public function updateProduct(Product $product, array $attributes)
    {
        $product->update($attributes);

        $deletedImageIds = $attributes['deletedImageIds'] ?? [];
        foreach ($deletedImageIds as $imageId) {
            $imageModel = ProductImage::find($imageId);
            if ($imageModel) {
                Storage::delete("product_images/$product->id/$imageModel->path");
                $imageModel->delete();
            }
        }

        $newImages = $attributes['newImages'];
        foreach ($newImages as $key => $image) {
            $imageModel = new ProductImage(['path' => basename($image->storeAs("product_images/$product->id", Str::random(10).'.'.$image->extension()))]);
            $product->images()->save($imageModel);
        }
    }

    public function deleteProducts(array $productIds)
    {
        foreach ($productIds as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $product->delete();
            }
        }
    }
}

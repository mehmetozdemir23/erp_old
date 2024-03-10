<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductIndexService
{
    public function getProducts(
        $sortColumn,
        $sortOrder,
        $search,
        $filters
    ) {
        $productsQuery = Product::query();

        $this->applySearch($productsQuery, $search);

        $this->applyFilters($productsQuery, $filters);

        $this->applySorting($productsQuery, $sortColumn, $sortOrder);

        $updatedFilters = $this->updateFilters($productsQuery);

        $products = $productsQuery
            ->with(['stock:id,quantity,product_id', 'category:id,name', 'images'])
            ->withCount(['sales'])
            ->paginate(7)
            ->withQueryString();

        $products->getCollection()->transform(function ($product) {
            return $product->setAttribute('thumbnail', $product->thumbnail());
        });

        return [$products, $updatedFilters];
    }

    protected function applySearch($query, $search)
    {
        $query->where('products.name', 'LIKE', $search.'%');
    }

    protected function applyFilters($query, $filters)
    {
        if (isset($filters['category'])) {
            $this->applyCategoryFilter($query, $filters['category']);
        }

        if (isset($filters['price'])) {
            $this->applyPriceFilter($query, $filters['price']);
        }
    }

    protected function applySorting($query, $sortColumn, $sortOrder)
    {
        if ($sortColumn === 'category.name') {
            $this->orderByCategoryName($query, $sortOrder);
        } elseif ($sortColumn === 'stock') {
            $this->orderByStock($query, $sortOrder);
        } elseif ($sortColumn === 'sales') {
            $this->orderBySalesCount($query, $sortOrder);
        } elseif ($sortColumn === 'revenue') {
            $this->orderByRevenue($query, $sortOrder);
        } else {
            $query->orderBy($sortColumn, $sortOrder);
        }
    }

    protected function applyCategoryFilter($query, $category)
    {
        if ($category !== 'all') {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('name', $category);
            });
        }
    }

    protected function applyPriceFilter($query, $priceInterval)
    {
        if ($priceInterval !== 'all') {
            [$minPrice, $maxPrice] = explode('-', $priceInterval);
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }
    }

    protected function orderByCategoryName($query, $sortOrder = 'asc')
    {
        if (! $this->isJoined($query, 'product_categories')) {
            $query
                ->join('product_categories', 'products.product_category_id', '=', 'product_categories.id');

        }
        $query->orderBy('product_categories.name', $sortOrder)
            ->select('products.*');
    }

    protected function orderByStock($query, $sortOrder = 'asc')
    {
        $query->join('product_stocks', 'products.id', '=', 'product_stocks.product_id')
            ->orderBy('quantity', $sortOrder);
    }

    protected function orderBySalesCount($query, $sortOrder = 'asc')
    {
        $query->withCount('sales')->orderBy('sales_count', $sortOrder);
    }

    protected function orderByRevenue($query, $sortOrder = 'asc')
    {
        $query->withCount('sales')->orderByRaw("sales_count * price $sortOrder");
    }

    protected function updateFilters($query)
    {
        $filteredQuery = $query->exists() ? $query : Product::query();

        $updatedFilters['price'] = $this->updatePriceFilter($filteredQuery);
        $updatedFilters['category'] = $this->updateCategoryFilter($filteredQuery);

        return $updatedFilters;
    }

    protected function updatePriceFilter($query)
    {
        $minPrice = floor($query->min('price') / 10) * 10;
        $maxPrice = ceil($query->max('price') / 10) * 10;

        $intervalSize = ($maxPrice - $minPrice) / 5;

        $priceIntervals = [];
        for ($i = 0; $i < 5; $i++) {
            $lowerBound = $minPrice + $i * $intervalSize;
            $upperBound = $lowerBound + $intervalSize;

            $lowerBound = number_format($lowerBound, 2);
            $upperBound = number_format($upperBound, 2);

            $priceIntervals[] = "$lowerBound-$upperBound";
        }

        return $priceIntervals;
    }

    protected function updateCategoryFilter($query)
    {
        $clonedQuery = $query->clone();
        if (! $this->isJoined($query, 'product_categories')) {
            $clonedQuery->join('product_categories', 'products.product_category_id', '=', 'product_categories.id');
        }

        return $clonedQuery
            ->selectRaw('product_categories.name as category_name')
            ->pluck('category_name')
            ->unique()->values()->toArray();
    }

    protected function isJoined($query, $table)
    {
        return Collection::make($query->getQuery()->joins)->pluck('table')->contains($table);
    }
}

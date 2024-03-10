<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductStock;
use App\Models\Sale;
use App\Models\SalesAgent;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->createProducts();
    }

    public function createProducts(): void
    {
        $categories = ProductCategory::factory(2)->create();
        $salesAgent = SalesAgent::factory()->for(User::factory())->create();

        foreach ($categories as $category) {
            $products = Product::factory()
                ->for($category, 'category')
                ->has(ProductStock::factory(), 'stock')
                ->count(20)
                ->create();

            foreach ($products as $product) {
                Sale::factory()
                    ->for(Customer::factory())
                    ->for($salesAgent, 'agent')
                    ->count(rand(1, 10))
                    ->create(['product_id' => $product->id]);
            }
        }
    }
}

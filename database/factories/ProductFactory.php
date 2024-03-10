<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 10, 20),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $image = fake()->image(width: 400, height: 300);
            $imagePath = Storage::putFileAs("product_images/$product->id", $image, Str::random(10).'.png');
            $product->images()->create(['path' => basename($imagePath)]);
            $product->save();
        });
    }
}

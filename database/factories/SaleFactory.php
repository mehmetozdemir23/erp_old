<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = rand(10, 50);
        $totalAmount = $quantity * 5;

        return [
            'quantity' => $quantity,
            'total_amount' => $totalAmount,
        ];
    }
}

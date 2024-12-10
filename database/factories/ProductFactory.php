<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => fake()->word,
            'description' => fake()->sentence,
            'price' => fake()->randomFloat(2, 10, 100), // Price between 10 and 100
            'quantity' => fake()->numberBetween(1, 100),
            'img' => fake()->imageUrl(),
            'store_id' => Store::inRandomOrder()->first()->id, // Assuming a store exists
        ];
    }
}

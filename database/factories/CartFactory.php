<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 'active',
            'quantity' => fake()->numberBetween(1, 5),
            'user_id' => User::inRandomOrder()->first()->id, // Assuming a user exists
            'product_id' => Product::inRandomOrder()->first()->id, // Assuming a product exis
        ];
    }
}

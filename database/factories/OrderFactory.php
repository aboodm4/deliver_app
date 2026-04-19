<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(['shipped', 'storeconfirm', 'transconfirm', 'userconfirm']),
            'payment' => $this->faker->randomElement(['cash', 'bank', 'syriatelcash', 'mtncash']),
            'total' => $this->faker->numberBetween(100, 1000),  // Fake total price between 100 and 1000
            'place' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'buildingfloor' => $this->faker->word,  // You can customize this
            'phone' => $this->faker->phoneNumber,
            'description' => $this->faker->text(200),  // Fake description
            'user_id' => User::factory(),  // Create a related user for the order
        ];
    }
}

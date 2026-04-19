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
        // return [
        //     'name' => fake()->word,
        //     'description' => fake()->sentence,
        //     'price' => fake()->randomFloat(2, 10, 100), // Price between 10 and 100
        //     'quantity' => fake()->numberBetween(1, 100),
        //     'time' => fake()->time(),
        //     'rate' => (string) fake()->numberBetween(1, 5),
        //     'img' => fake()->imageUrl(),
        //     'store_id' => Store::inRandomOrder()->first()->id, // Assuming a store exists
        // ];
        $store = Store::inRandomOrder()->first();

        return [
            'name' => $this->faker->word, // Random product name
            'description' => $this->faker->sentence, // Random description
            'price' => $this->faker->randomFloat(2, 10, 1000), // Random price between 10 and 1000
            'time' => $this->faker->time, // Random time, could be opening hours or similar
            'rate' => $this->faker->randomFloat(1, 0, 5), // Random rating between 0 and 5
            'quantity' => $this->faker->randomNumber(2, false), // Random quantity (e.g., 10, 100, etc.)
            'arname' => $this->faker->word, // Random Arabic name (adjust as needed)
            'ardescription' => $this->faker->sentence, // Random Arabic description
            'img' => $this->faker->imageUrl(640, 480, 'products', true), // Random image URL
            'store_id' => $store ? $store->id : Store::factory(), // Associate with a random store or create one if none exists
        ];
    }
}

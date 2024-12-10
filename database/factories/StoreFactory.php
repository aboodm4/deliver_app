<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Store;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    // protected $model = Store::class;

    /**
     * Define the model's default state.

     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company,
            'location' => fake()->address,
            'storehead_id' => User::where('role', 'storehead')->inRandomOrder()->first()->id, // assuming there's at least one storehead
        ];
    }

}

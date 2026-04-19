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
        // return [
        //     'name' => fake()->company,
        //     'location' => fake()->address,
        //     'description' => fake()->address(),
        //     'rate' => (string) fake()->numberBetween(1, 5),
        //     'storehead_id' => User::where('role', 'storehead')->inRandomOrder()->first()->id, // assuming there's at least one storehead
        // ];
        $storehead = User::where('role', 'admin')->inRandomOrder()->first();

        // If no admin user exists, you may want to handle this case, e.g.:
        if (!$storehead) {
            $storehead = User::factory()->create(['role' => 'admin']); // Create a new admin if needed
        }

        return [
            'name' => $this->faker->company, // Random company name
            'arname' => $this->faker->word, // Random Arabic name (adjust as needed)
            'location' => $this->faker->address, // Random address
            'arlocation' => $this->faker->address, // Random Arabic address
            'description' => $this->faker->sentence, // Random description
            'ardescription' => $this->faker->sentence, // Random Arabic description
            'rate' => $this->faker->randomFloat(2, 0, 5), // Random rating between 0 and 5
            'storehead_id' => $storehead->id, // The ID of the random admin user
        ];
    }

}

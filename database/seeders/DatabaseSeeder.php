<?php

namespace Database\Seeders;

use App\Models\Cart;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Order;
use App\Models\Store;
use App\Models\Product;
use App\Models\Favourite;
use App\Models\CartProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();

    //     User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //     ]);
    // }
    public function run()
    {
        $admin = User::create([
            'first_name' => 'aboodm',
            'last_name' => 'moj',
            'phone' => '0967778931',
            'role' => 'admin',
            'email' => 'abood.com',
            'password' => bcrypt('00000000'),
        ]);
        $user = User::create([
            'first_name' => 'abd',
            'last_name' => 'm',
            'phone' => '0900000000',
            'role' => 'delivery',
            'email' => 'aa.com',
            'password' => bcrypt('00000000'),
        ]);

        // Seed Users
        User::factory(10)->create();

        // Seed Stores
        Store::factory(5)->create(); // 5 stores, each with a storehead

        // Seed Products
        Product::factory(20)->create(); // 20 products

        // Seed Carts
        Cart::factory(10)->create(); // 10 carts, each belonging to a user

        // Seed CartProducts
        // CartProduct::factory(30)->create(); // 30 cart-product links

        Favourite::factory(5)->create();

        // seed carts
        Cart::factory(5)->create();

        // seed orders
        // Order::factory()->count(2)->create();

    }
}

<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class StoreConcurrencyTest extends TestCase
{
    public function test_inventory_deduction_concurrency()
    {
        // $user = User::factory()->create(['role' => 'admin']);
        $user = User::first();
        $store = Store::create([
            'name' => 'المتجر المتميز',
            'location' => 'دمشق',
            'storehead_id' => $user->id
        ]);
        
        $product = Product::create([
            'name' => 'منتج حصري',
            'price' => '1000',
            'quantity' => '400',
            'store_id' => $store->id,
            'rate' => '5'
        ]);

        $productId = $product->id;

        $results = [];
        for ($i = 0; $i < 100; $i++) {
            try {
                $response = $this->actingAs($user)->postJson('/api/product/minus-product', [
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
                $results[] = $response->status();
            } catch (\Exception $e) {
            }
        }

    }

}

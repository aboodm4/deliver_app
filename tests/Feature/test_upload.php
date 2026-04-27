<?php

namespace Tests\Feature;

use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class TestUploadConcurrency extends TestCase
{
    public function test_massive_concurrency_upload()
    {
        config(['queue.default' => 'database']);
        $user = User::first();
        $store = Store::create([
            'name' => 'tessdttts',
            'location' => ' fdasjlfj',
            'storehead_id' => $user->id
        ]);

        for ($i = 1; $i <= 100; $i++) {
            $file = UploadedFile::fake()->create("product_{$i}.png", 50);

            $response = $this->actingAs($user)->postJson('/api/product/upload', [
                'file' => $file,
                'store_id' => $store->id
            ]);

            $response->assertStatus(202);

        }
 }
}

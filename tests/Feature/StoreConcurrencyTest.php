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
    use RefreshDatabase;

    /**
     * اختبار التضارب (Race Condition Test)
     * نقوم بمحاكاة 100 محاولة شراء متزامنة لمنتج يحتوي على 50 قطعة فقط
     * الهدف: التأكد أن المخزون لن يصبح سالباً أبداً وأن العملية محمية بـ Transactions & Locks
     */
    public function test_inventory_deduction_concurrency()
    {
        // 1. إعداد البيانات
        $user = User::factory()->create(['role' => 'admin']);
        $store = Store::create([
            'name' => 'المتجر المتميز',
            'location' => 'دمشق',
            'storehead_id' => $user->id
        ]);
        
        $product = Product::create([
            'name' => 'منتج حصري',
            'price' => '1000',
            'quantity' => '50', // لدينا 50 قطعة فقط
            'store_id' => $store->id,
            'rate' => '5'
        ]);

        $productId = $product->id;

        // 2. محاكاة العمليات المتوازية باستخدام PHP Threads (أو ببساطة عبر حلقة تكرار تحاكي الضغط)
        // في بيئة الاختبار الحقيقية نستخدم أدوات مثل Apache Benchmark أو JMeter
        // هنا سنقوم بمحاكاة المنطق البرمجي لـ 100 عملية
        
        $results = [];
        for ($i = 0; $i < 100; $i++) {
            // محاكاة استدعاء الدالة البرمجية مباشرة لاختبار قفل قاعدة البيانات
            try {
                $response = $this->actingAs($user)->postJson('/api/product/deduct-inventory', [
                    'product_id' => $productId,
                    'quantity' => 1
                ]);
                $results[] = $response->status();
            } catch (\Exception $e) {
                // خطأ تضارب
            }
        }

        // 3. التحقق من النتائج
        $finalProduct = Product::find($productId);
        
        // يجب أن يكون المخزون 0 وليس سالباً
        $this->assertEquals(0, (int)$finalProduct->quantity);
        
        // يجب أن نجد 50 عملية ناجحة (200) و 50 عملية مرفوضة (400) لنقص المخزون
        $successCount = count(array_filter($results, fn($status) => $status === 200));
        $this->assertEquals(50, $successCount);
    }
}

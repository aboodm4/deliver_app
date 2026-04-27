<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::all();

        return response()->json([
            'stores' => $stores,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['storehead_id'] = Auth::id();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->move('uploads',
                Str::uuid()->toString() . '-' . $request->file('img')->getClientOriginalName());
        }

        Store::create($data);

        return response()->json([
            'message' => 'Store added successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $store = Store::find( $id );
        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }
        $products = Product::where( 'store_id', operator: $store->id)->get();

        return response()->json([
            'store' => $store,
            'products'=> $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

/**
 * آلية Semaphore للتحكم في الضغط على قاعدة البيانات
 */
// public function getProductStats($id)
// {
//     $lockKey = 'product_stats_semaphore_';
//     $lock = Cache::lock($lockKey . $id, 5); // قفل لمدة 5 ثوانٍ

//     if ($lock->get()) {
//         try {
//             $product = Product::findOrFail($id);
//             // عملية استعلام مكلفة تحاكي قراءة سجلات المبيعات أو الإحصائيات
//             return response()->json(['name' => $product->name, 'stock' => $product->quantity]);
//         } finally {
//             $lock->release();
//         }
//     } else {
//         return response()->json(['message' => 'System under heavy load, try again later.'], 429);
//     }
// }
    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request)
    {
        $data = $request->validated();
        $store = Store::find($request->store_id);

        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }

        if ($request->hasFile('img')) {
            // Optional: Delete old image from storage if it exists
            if ($store->img && file_exists(public_path($store->img))) {
                unlink(public_path($store->img));
            }

            $data['img'] = $request->file('img')->move('uploads',
                Str::uuid()->toString() . '-' . $request->file('img')->getClientOriginalName());
        }

        $store->update($data);

        return response()->json([
            'message' => 'Store updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the store by ID
        $store = Store::find($id);

        // Check if the store exists
        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }

        // Products will be deleted automatically due to Cascade Delete in migration.

        // Delete the store
        $store->delete();

    }
}

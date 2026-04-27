<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Jobs\ProcessProductUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        return response()->json([
            'product'=>$product
        ],200);
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

     public function store(Request $request)
     {
         // Validate the incoming request data
         $validated = $request->validate([
             'name' => 'required|string|max:100',
             'description' => 'required|string',
             'price' => 'required|string|regex:/^\d+$/',  // Price should be a numeric string
             'quantity' => 'required|string|regex:/^\d+$/',  // Quantity should be a numeric string
             'time' => 'nullable|string|regex:/^\d+$/',  // Time should be a numeric string (nullable)
             'rate' => 'required|string|in:1,2,3,4,5',  // Rate should be a string between 1 and 5
             'store_id' => 'required|string|exists:stores,id',
             'arname' => 'nullable|string',
             'ardescription' => 'nullable|string',
             'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Ensure valid image
         ]);

         // Handle the image upload if there is an image file
         $imagePath = null;
        //  if ($request->hasFile('img')) {
        //      $image = $request->file('img');
        //      $imagePath = $image->store('public/products');  // Store in 'storage/app/public/products'
        //  }
         if($request->img != null){
            $imagePath = $request->img ->move('uploads',
            Str::uuid()->toString() . '-' . $request->img->getClientOriginalName());
        }


         // Create the product record in the database
         $product = Product::create([
             'name' => $validated['name'],
             'description' => $validated['description'],
            //  'arname' => $validated['arname'],
            //  'ardescription' => $validated['ardescription'],
             'price' => $validated['price'],
            //  'time' => $validated['time'],
             'rate' => $validated['rate'],
             'quantity' => $validated['quantity'],
             'img' => $imagePath,  // Store the image path if an image was uploaded
             'store_id' => $validated['store_id'],
         ]);
         if ($request->has('time')) {
            $product['time'] = $validated['time'];
        }
         if ($request->has('arname')) {
            $product['arname'] = $validated['arname'];
        }
         if ($request->has('ardescription')) {
            $product['ardescription'] = $validated['ardescription'];
        }
        $product->save();
         // Check if the product was created successfully
         if ($product) {
             return response()->json([
                 'product' => $product,
                 'message' => 'Product created successfully.',
             ], 200); // Corrected response formatting
         } else {
             return response()->json([
                 'message' => 'Error occurred while creating the product.',
             ], 400); // Corrected response formatting
         }
     }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }
        return response()->json([
            'product'=>$product
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
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $attributes = request()->validate([
            'product_id'=>'required|string|exists:products,id',
                'name' => 'required|string|max:100',
                'description' => 'required|string',
                'price' => 'required|string|regex:/^\d+$/',  // Price should be a numeric string
                'quantity' => 'required|string|regex:/^\d+$/',  // Quantity should be a numeric string
                'time' => 'nullable|string|regex:/^\d+$/',  // Time should be a numeric string (nullable)
                'rate' => 'required|string|in:1,2,3,4,5',  // Rate should be a string between 1 and 5
                'store_id' => 'required|string|exists:stores,id',
                'arname' => 'nullable|string',
                'ardescription' => 'nullable|string',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Ensure valid image
            ]);
        if($request->img != null){
            $imagePath = $request->img ->move('uploads',
            Str::uuid()->toString() . '-' . $request->img->getClientOriginalName());
            $attributes['img'] = $imagePath;
        }
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'message' => 'product not found',
            ],400);
        }
        // $attribute=request()->validate([
        //     'name'=>['required'],
        //     'description'=>['nullable'],
        //     'price'=>['nullable'],
        //     'quantity'=>['nullable']
        // ]);
        $product->update($attributes);

        return response()->json([
            'message' => 'product edit successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        // Check if the store exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);
        }

        // Delete all products associated with this store

        // Delete the store
        $product->delete();
        return response()->json([
            'message' => 'Product has been deleted successfully.',
        ]);
    }


    public function MinusProduct(Request $request)
    {
        $productId = $request->product_id;
        $quantityToDeduct = $request->quantity;

        try {
            return DB::transaction(function () use ($productId, $quantityToDeduct) {

                $product = Product::where('id', $productId)->lockForUpdate()->first();

                if (!$product) {
                    return response()->json(['message' => 'Product not found'], 404);
                }

                if ((int)$product->quantity < $quantityToDeduct) {
                    return response()->json(['message' => 'Insufficient stock'], 400);
                }

                $product->quantity = (int)$product->quantity - $quantityToDeduct;
                $product->save();

                return response()->json([
                    'message' => 'Inventory deducted successfully',
                    'new_quantity' => $product->quantity
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => 'Concurrency error: ' . $e->getMessage()], 500);
        }
    }


    public function UploadProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xls,xlsx,csv,pdf,png,webp',
            'store_id' => 'required|exists:stores,id'
        ]);

        $path = $request->file('file')->store('temp_uploads');
        $absolutePath = storage_path('app/' . $path);

        ProcessProductUpload::dispatch($absolutePath, $request->store_id);

        return response()->json([
            'message' => 'Bulk upload started in the background (Thread Pool processing).',
        ], 202);
    }





}




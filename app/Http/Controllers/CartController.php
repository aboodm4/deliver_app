<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Favourite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the user ID from the authenticated user
        $user_id = Auth::user()->id;

        // Fetch the user's cart
        $cart = Cart::where('user_id', $user_id)->where('status', 'active')->get();

        // Check if the cart is empty
        if ($cart->isEmpty()) {
            return response()->json([
                'message' => 'You don\'t have any products in your cart.',
            ], 200);
        }

        // Get all product IDs from the cart
        $productIds = $cart->pluck('product_id')->toArray();

        // Fetch all products in one query using whereIn to minimize database queries
        $products = Product::whereIn('id', $productIds)->get();

        // Create an array to hold the cart data with product details and quantity
        $cartProducts = $cart->map(function ($cartItem) use ($products) {
            // Find the product corresponding to the cart item
            $product = $products->firstWhere('id', $cartItem->product_id);

            // Return the combined product data along with the quantity
            return [
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'product' => $product,
            ];
        });

        // Return the response with the cart products data
        return response()->json([
            'cartproducts' => $cartProducts,
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'quantity' => 'required|integer|min:1',  // Quantity must be a positive integer
            'product_id' => 'required|integer|exists:products,id',  // product_id must be a valid integer and must exist in products table
        ]);

        // Get authenticated user's ID
        $user_id = Auth::user()->id;
        $product_id = $request->product_id;
        $qty = $request->quantity;

        // Fetch the product to check available stock
        $product = Product::find($product_id);

        // Check if the product exists
        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
            ], 404);  // Return 404 if the product doesn't exist
        }

        // Check if the requested quantity is available in stock
        if ($qty > $product->quantity) {
            return response()->json([
                'message' => 'You can\'t add more than the available stock.',
            ], 400);  // Return 400 if requested quantity exceeds stock
        }

        // Check if the product is already in the user's cart
        $productcart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->where('status', 'active')->first();

        if ($productcart) {
            // If product already in cart, update the quantity
            $newQuantity = $productcart->quantity + $qty;

            // Check if the updated quantity exceeds available stock
            if ($newQuantity > $product->quantity) {
                return response()->json([
                    'message' => 'You can\'t have more than the available stock.',
                ], 400);  // Return 400 if new quantity exceeds stock
            }

            // Update the cart item quantity and save
            $productcart->quantity = $newQuantity;
            $productcart->save();

            return response()->json([
                'message' => 'Product quantity updated in the cart.',
            ], 200);  // Return success response if the cart is updated
        }

        // If the product is not in the cart, create a new cart entry
        $newcart = new Cart();
        $newcart->user_id = $user_id;
        $newcart->product_id = $product_id;
        $newcart->quantity = $qty;
        $newcart->status = 'active';

        // Save the new cart entry
        $newcart->save();

        return response()->json([
            'message' => 'Product added to the cart.',
        ], 200);  // Return success response when new product is added
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     $user_id = Auth::user()->id;
    //     $product_id = $id;

    //     $favourite = Favourite::where('user_id', $user_id)->where('product_id', $product_id)->first();
    //     if (!$favourite) {
    //         return response()->json([
    //             'message' => 'error',
    //         ], 400);
    //     }

    //     $favourite->delete();
    //     return response()->json([
    //         'message' => 'the product removed from favourite'
    //     ],200);
    // }
    public function destroy($productId)
{
    // Get the authenticated user's ID
    $user_id = Auth::user()->id;

    // Find the cart item by the product_id and user_id
    $cartItem = Cart::where('user_id', $user_id)
                    ->where('product_id', $productId)
                    ->where('status', 'active')
                    ->first();

    // Check if the cart item exists
    if (!$cartItem) {
        return response()->json([
            'message' => 'Product not found in your cart.',
        ], 404);
    }

    // Delete the cart item
    $cartItem->delete();

    // Return a success response
    return response()->json([
        'message' => 'Product has been removed from your cart.',
    ], 200);
}

public function AddOne(Request $request)
{
    $user_id = Auth::user()->id;
    // Validate the request to make sure we have a valid product ID
    $request->validate([
        'product_id' => 'required|integer|exists:products,id', // Make sure the product exists
    ]);

    $product_id = $request->input('product_id');

    $productcart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->where('status', 'active')->first();
    $product = Product::find($product_id);

    // Check if the product is already in the cart
    if ($productcart) {
        if ($productcart->quantity+1 > $product->quantity) {
            return response()->json([
                'message' => 'You can\'t have more than the available stock.',
            ], 400);
        }
        // Increase the quantity of the product by 1
        $productcart->quantity += 1;
        $productcart->save();
    } else {
        return response()->json([
            'message' => 'add product first',
        ],400);
    }

    // Return a response (could be a redirect, JSON response, etc.)
    return response()->json([
        'message' => 'Product quantity increased by 1',
    ],200);
}

    public function RemoveOne(Request $request)
    {
        $user_id = Auth::user()->id;
        // Validate the request to make sure we have a valid product ID
        $request->validate([
            'product_id' => 'required|integer|exists:products,id', // Make sure the product exists
        ]);

        $product_id = $request->input('product_id');

        $productcart = Cart::where('user_id', $user_id)->where('product_id', $product_id)->where('status', 'active')->first();

        // Check if the product is already in the cart
        if ($productcart) {
            // Increase the quantity of the product by 1
            if ($productcart->quantity == 1) {
                $productcart->delete();
            } else {
                $productcart->quantity -= 1;
                $productcart->save();
            }
        } else {
            return response()->json([
                'message' => 'add product first',
            ],400);
        }

        // Return a response (could be a redirect, JSON response, etc.)
        return response()->json([
            'message' => 'Product quantity decreased by 1',
        ],200);
    }

}

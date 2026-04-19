<?php

namespace App\Http\Controllers;

use App\Models\Favourite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FavouriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $favproduct = Favourite::where('user_id',$user_id)->get();
        if (!$favproduct) {
            return response()->json([
                'message' => 'you dont have products in fav',
            ],400);
        }
        $productsfavorite = collect();
        foreach ($favproduct as $value) {
            $product = Product::find($value->product_id);
            $productsfavorite->push($product);
        }
        return response()->json([
            'productsfavorite'=>$productsfavorite
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,string $id)
    {
        $user_id = Auth::user()->id;
        $product_id = $id;

        $favourite = Favourite::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if ($favourite) {
            return response()->json([
                'message' => 'you have this product in fav',
            ], 400);
        }

        $product = Product::where('id',$product_id)->first();
        if (!$product) {
            return response()->json([
                'message' => 'product dont found',
            ], 404);
        }

        Favourite::create([
            'user_id'=>$user_id,
            'product_id'=>$product_id
        ]);

        return response()->json([
            'message' => 'product added in fav',
        ], 200);
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
    public function destroy(string $id)
    {
        $user_id = Auth::user()->id;
        $product_id = $id;

        $favourite = Favourite::where('user_id', $user_id)->where('product_id', $product_id)->first();
        if (!$favourite) {
            return response()->json([
                'message' => 'error',
            ], 400);
        }

        $favourite->delete();
        return response()->json([
            'message' => 'the product removed from favourite'
        ],200);
    }
}

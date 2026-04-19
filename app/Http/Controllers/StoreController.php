<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function Pest\Laravel\json;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Auth;
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
        $request->validated();
        $user_id = Auth::user()->id;

        $newstore = new Store();
        $newstore->name = $request->name;
        $newstore->arname = $request->arname;
        $newstore->location = $request->location;
        $newstore->arlocation = $request->arlocation;
        $newstore->description = $request->description;
        $newstore->ardescription = $request->ardescription;
        $newstore->rate = $request->rate;
        if($request->img != null){
            $path = $request->img ->move('uploads',
            Str::uuid()->toString() . '-' . $request->img->getClientOriginalName());
            $newstore->img = $path;
        }
        $newstore->storehead_id = $user_id;
        $newstore->save();

        return response()->json([
            'message' => 'store added successful',
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
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request)
    {
        $request->validated();
        $user_id=Auth::user()->id;
        $store = Store::find( $request->store_id );
        if (!$store) {
            return response()->json([
                'message' => 'Store not found.',
            ], 404);
        }
        $store->name = $request->name;
        $store->arname = $request->arname;
        $store->location = $request->location;
        $store->arlocation = $request->arlocation;
        $store->description = $request->description;
        $store->ardescription = $request->ardescription;
        $store->rate = $request->rate;
        if($request->img != null){
            $path = $request->img ->move('uploads',
            Str::uuid()->toString() . '-' . $request->img->getClientOriginalName());
            $store->img = $path;
        }
        $store->storehead_id = $user_id;
        $store->save();

        return response()->json([
            'message' => 'store edit successfully',
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

        // Delete all products associated with this store
        Product::where('store_id', $store->id)->delete();

        // Delete the store
        $store->delete();

        return response()->json([
            'message' => 'Store and its products deleted successfully.',
        ]);
    }

}

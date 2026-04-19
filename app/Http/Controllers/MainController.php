<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function UserShow()
    {
        $user_id = Auth::user()->id;
        $user = User::find( $user_id );
        return response()->json([
            'user' => $user,
        ]);
    }

    public function UserUpdate(Request $request)
    {
        // Get the current user's ID
        $user_id = Auth::user()->id;

        // Validate the incoming request data
        $attributes = request()->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            // 'phone' => ['required', 'string', 'max:10', 'min:10', 'unique:'.User::class],
            'phone' => [
                'required',
                'string',
                'max:10',
                'min:10',
                'unique:users,phone,' . $user_id,  // Exclude the current user's phone number from the unique check
            ],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:users,email,' . $user_id,  // Exclude the current user's email from the unique check
            ],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],  // Ensure the 'img' is an image file if provided
            'location' => ['nullable', 'string', 'max:255'],  // Optional field with validation
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // Handle image upload if present
        $imagePath = null;
        // if ($request->hasFile('img')) {
        //     $image = $request->file('img');
        //     $imagePath = $image->store('public/users');  // Store in 'storage/app/public/users'
        //     $attributes['img'] = $imagePath;
        // }
        if($request->img != null){
            $imagePath = $request->img ->move('uploads',
            Str::uuid()->toString() . '-' . $request->img->getClientOriginalName());
            $attributes['img'] = $imagePath;
        }

        // Handle location update if present
        if ($request->has('location')) {
            $attributes['location'] = $request->input('location');
        }

        // Find and update the user
        $user = User::find($user_id);
        if ($user) {
            $user->update($attributes);

            return response()->json([
                'message' => 'User updated successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }


    //get all users
    public function index() {
            $users = User::all();
            return response()->json([
                'users' => $users,
            ]);
    }

    //delete user
    public function destroy(string $id)
    {
            $user = User::find($id)->delete();
            if (!$user) {
                return response()->json([
                    'message' => 'user doesnt exist',
                ], 400);
            }
            return response()->json([
                'message' => 'user deleted successfully',
            ], 200);

    }

    //add user
    public function store(Request $request)
    {
            $request=request()->validate([
                'first_name' => ['required', 'string', 'max:50'],
                'last_name' => ['required', 'string', 'max:50'],
                'phone' => ['required', 'string', 'max:10', 'min:10', 'unique:'.User::class],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                'img'=>['nullable'],
                'location'=>['nullable'],
                'password' => ['required','confirmed',  Rules\Password::defaults()],
            ]);

            $user = User::create($request);
            return response()->json([
                'message' => 'user added successfully',
            ], 200);
    }




    public function Search(Request $request)
    {
        $qry = $request->input('qry');

        if (!$qry) {
            return response()->json(['message' => 'Search qry is required'], 400);
        }
        // Search in the products table
        $products = Product::where('name', 'like', '%'.$qry.'%')
            ->orWhere('description', 'like', '%'.$qry.'%')
            ->get();

        // Search in the stores table (assuming stores also have a 'name' or 'location' to search)
        $stores = Store::where('name', 'like', '%'.$qry.'%')
            ->orWhere('location', 'like', '%'.$qry.'%')
            ->get();

        // Combine both results and return them
        return response()->json([
            'products' => $products,
            'stores' => $stores,
        ], 200);
    }

    public function LastProducts() {
        $products = Product::orderBy('created_at', 'desc')->take(15)->get();

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function MakeDeliver(Request $request) {
        $user_id = auth()->user()->id;

        $usereditid = $request->validate(['user_id'=> ['required', 'string', 'exists:users,id']]);

        $user = User::find($usereditid);
        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }
        if ($user->role == 'delivery') {
            return response()->json([
                'message' => 'user is already delivery'
            ], 404);
        }
        $user->role = 'delivery';
        $user->save();

        return response()->json([
            'message' => 'user updated to deliver successfully'
        ], 200);
    }
    public function MakeUser(Request $request) {
        $user_id = auth()->user()->id;

        $usereditid = $request->validate(['user_id'=> ['required', 'string', 'exists:users,id']]);

        $user = User::find($usereditid);
        if (!$user) {
            return response()->json([
                'message' => 'user not found'
            ], 404);
        }
        if ($user->role == 'user') {
            return response()->json([
                'message' => 'user is already user'
            ], 404);
        }
        $user->role = 'user';
        $user->save();

        return response()->json([
            'message' => 'user updated to user successfully'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

}

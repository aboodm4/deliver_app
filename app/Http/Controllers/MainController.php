<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
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
    // public function UserEdit()
    // {
    //     // $user_id = auth()->user()->id;
    //     $user_id = Auth::user()->id;

    //     $user = User::find( $user_id );
    //     return response()->json([
    //         'user' => $user,
    //     ]);
    // }

    public function UserUpdate(Request $request)
    {
        $user_id = Auth::user()->id;
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:10|unique:users,phone,' . $user_id, // Exclude current user’s phone
            'email' => 'nullable|email|unique:users,email,' . $user_id,  // Validates email if provided, ensures it's unique
            'img' => 'nullable|url', // You can validate the image URL or provide another rule based on the field type
            'location' => 'nullable|string|max:255', // Location as a string, with a max length
            'password' => 'required|string|min:8', // Password must be at least 8 characters, and confirmed
        ]);

        $user = User::find( $user_id );
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->img = $request->img;
        $user->location = $request->location;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'user edit successfully',
        ]);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

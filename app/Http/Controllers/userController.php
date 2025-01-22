<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['message' => 'Get all data', 'data' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user){
            return response()->json(['message' => 'Email already exists'], 400);
        }

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Create new user', 'data' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return response()->json(['message' => 'Get data', 'data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user = User::find($id);
        if (!$user){
            return response()->json(['message' => 'User not found'], 404);
        }
       
        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'Update user', 'data' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user){
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->disabled = true;
        return response()->json(['message' => 'Delete user', 'data' => $id]);
    }
}

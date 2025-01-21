<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

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

        // find if the email already exists
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
            'name' => 'required',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'User updated', 'data' => $user]);
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

        $user->delete();
        return response()->json(['message' => 'Delete user', 'data' => $id]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        // Check if the credentials are correct in the database
        $user = User::where('email', $credentials['email'])->first();
        if (!$user){
            return response()->json(['message' => 'Email not found'], 404);
        }

        // Check if the password is correct
        if (!password_verify($credentials['password'], $user->password)){
            return response()->json(['message' => 'Password is incorrect'], 404);
        }

        // Generate token
        $token = JWTAuth::fromUser($user);
        return response()->json(['message' => 'Login success', 'token' => $token]);
        
    }


}

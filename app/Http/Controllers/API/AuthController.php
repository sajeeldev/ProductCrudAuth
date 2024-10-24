<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\AUTH\LoginRequest;
use App\Http\Requests\AUTH\RegisterRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

// -------------------------------------------------------------------------------------------------------

    // Register method to register the user
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $user = User::create($data);
        $token = $user->createToken($request->name);
        return response()->json([
            'message' => 'User Registered Successfully',
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

// -------------------------------------------------------------------------------------------------------

    // Login method for user login
    public function login(LoginRequest $request){
        $validated = $request->validated();
        // Fetch the user by email
        $user = User::where('email', $validated['email'])->first();

        // Check if user exists and password is correct
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json(['message' => 'Credentials are incorrect'], 401);
        }

        // Fetch products belonging to the user and the user's address
        // $products = $user->product()->where('user_id', $user->id)->get();

        // Array based query to return the product of the user When the user access the login page
        $products = Product::where([
                    'user_id' => $user->id,
                    ])->get();

        // Creating token for User Login
        $token = $user->createToken($user->name);

        // Returning the response of input
        return response()->json([
            'message' => 'Login Successful',
            'data' => $user,
            'product' => $products,
            'token' => $token->plainTextToken
        ]);

        // $product = User::with('product')->get('id');
        // if (Auth::attempt($user))
        // {
        // $user = Auth::user();
        // $token = $user->createToken($user->name);
        // return response()->json([
        //     'message' => 'login successful',
        //     'data' => $user, $product,
        //     'token' => $token->plainTextToken
        // ]);
        // }
    }


// -------------------------------------------------------------------------------------------------------

    // Logout Method to logout the user
    public function logout(Request $request){
        $request->user()->token()->delete();
        return 'Logout Successfull';
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function register(Request $request){
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
         // Create a new user instance
         $user = admin::create($validate);

         // Save the user to the database
         $user->save();
 
         // You can also log in the user if needed
         // auth()->login($user);
         // Redirect to a success page or return a response
         return response()->json([
             'user'=>$user
 
         ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password', 'id');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            return response()->json([
                'user'=>$user,
                
            ]);
        }

        return response()->json([
            'error', 'Invalid Credentials'
        ]);
    }
}

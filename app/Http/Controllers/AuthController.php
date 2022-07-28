<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return User::all();
    }
    
    public function register (Request $request)
    {
        $fields = $request->validate( [
            'name' => 'required|regex:/^[a-z A-Z.-]+$/',
            'phone' => 'required|digits:11|unique:users,phone',
            'email' => 'required|email|unique:users,email',       
            'verification' => 'required',                                
            'password' => 'required|min:3',                   
            'address' => 'required',
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'phone' => $fields['phone'],
            'email' => $fields['email'],
            'verification' => $fields['verification'],
            'password' => bcrypt($fields['password']),
            'address' => $fields['address'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response ($response, 201);
    }

    public function login (Request $request)
    {
        $fields = $request->validate( [
            'email' => 'required|email',                                      
            'password' => 'required|min:3'
        ]);
        $user = User::where('email', $fields['email'])->first();
        // return $user;
        if(!$user || !Hash::check($fields['password'], $user->password))
        {
            return response([
                'message' => "bad creds",
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response ($response, 201);
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged Out'
        ];
    }

    public function checkId(Request $request)
    {
        // return 'ID is: '. auth()->user()->id;        
    }
}

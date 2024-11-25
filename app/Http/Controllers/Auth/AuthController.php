<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\ProductController;
use App\User;
use Illuminate\Support\Facades\Auth; // Ensure this line is included

class AuthController extends Controller
{
    // Show the login form
    // public function showLoginForm()
    // {
    //     return view('loginform'); // Ensure you have a view for this form
    // }

    public function login(LoginRequest $request)
    {
        //
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        //return view('regform'); // Ensure you have a view for this form
    }

    // Handle registration submission
    public function register(RegisterRequest $request)
    {
        // // Create a new user
        // $user = User::create([
        //     'employee_name' => $request->employee_name,
        //     'username' => $request->username,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // // Log the user in
        // auth()->login($user);

        // // Redirect to a desired route
        // return redirect()->route('loginForm')->with('success', 'Registration successful!');
    }

    // Handle logout
    public function logout()
    {
        // Auth::logout();
        // session()->flush();

        // // Redirect to the login page after logout
        // return redirect()->route('loginForm');
    }
}

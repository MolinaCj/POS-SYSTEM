<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Log;

use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth; // Ensure this line is included
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('loginform'); // Ensure you have a view for this form
    }

    public function login(LoginRequest $request)
    {
        // The request is automatically validated before this method is called
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Redirect to the intended route or to the products view
            return redirect()->intended('/products');
        }

        // Redirect back with an error if login fails
        return back()->withErrors(['username' => 'Invalid username or password.']);
    }

    // Show the registration form
    public function showRegistrationForm()
    {
        return view('regform'); // Ensure you have a view for this form
    }

    // Handle registration submission
    public function register(RegisterRequest $request)
{
    // The validation is automatically handled by the RegisterRequest class

    Log::info($request->all());

    // Create the user
    Employee::create([
        'employee_name' => $request->input('employee_name'),
        'username' => $request->input('username'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
    ]);

    // Redirect to the login page after successful registration
    return redirect()->route('loginForm')->with('status', 'Registration successful. Please login.');
}

    // Handle logout
    public function logout()
    {
        Auth::logout();
        session()->flush();

        // Redirect to the login page after logout
        return redirect()->route('loginForm');
    }
}

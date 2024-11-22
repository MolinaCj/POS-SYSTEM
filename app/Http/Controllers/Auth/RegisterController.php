<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    protected $redirectTo = '/loginForm';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Update the register method to use RegisterRequest for validation
    public function register(RegisterRequest $request)
    {
        // The request has already been validated by RegisterRequest

        // Create the new employee
        $user = User::create([
            'employee_name' => $request->input('employee_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Optionally log in the user after registration (if needed)
        // Auth::login($employee);

        // Redirect to the login form after successful registration
        return redirect()->route('loginform')->with('status', 'Registration successful. Please login.');
    }
}

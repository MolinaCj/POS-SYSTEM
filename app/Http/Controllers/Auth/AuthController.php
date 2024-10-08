<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Ensure this line is included
use App\User;

class AuthController extends Controller
{
    public function getLogin()
    {
        return view('loginform');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/products'); // Change to your intended route
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function getRegister()
    {
        return view('regform');
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect('loginform'); // Change to your intended route
    }

    public function logout()
    {
        Auth::logout();
        return redirect('loginform'); // Redirect to login page
    }
}

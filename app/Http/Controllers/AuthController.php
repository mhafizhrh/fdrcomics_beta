<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    protected function login()
    {
    	if (Auth::check()) {
			return redirect('/');
		}

    	return view('auth.login');
    }

    protected function loginValidate(Request $request)
    {
    	$credentials = $request->only('username', 'password');

        if (Auth::guard()->attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'username' => 'Username or Password incorrect.',
        ]);
    }

    protected function register(Request $request)
    {
        return view('auth.register');
    }

    protected function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'username' => 'required|unique:users',
            'password' => 'required|min:8|confirmed'
        ]);

        $store = User::insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => password_hash($request->input('password'), PASSWORD_DEFAULT)
        ]);

        return redirect(route('login'))->with('status', 'Register success. Please Login.');
    }

    protected function logout()
    {
    	return redirect()->route('login')->with(Auth::logout());
    }
}

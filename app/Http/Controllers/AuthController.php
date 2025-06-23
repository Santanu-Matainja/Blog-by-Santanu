<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials) && Auth::user()->isAdmin()) {
            $request->session()->regenerate();
            
            return redirect()->route('admin.blogs');
        }
        else if(Auth::attempt($credentials) && Auth::user()->user_type === 'user' ){
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }


        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login.form');
    }
}

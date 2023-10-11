<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => trans('auth.email_requried'),
            'email.email' => trans('auth.email_valid'),
            'password.required' => trans('auth.password_requried'),
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,

        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return to_route('login')->with(['invalid' => trans('auth.failed')]);

    }
}

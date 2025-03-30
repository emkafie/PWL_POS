<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            // User is already authenticated, redirect to the intended page or dashboard
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');
            if (Auth::attempt($credentials)) {
                // Authentication passed...
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful',
                    'redirect' => url('/'),
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ], 401);
        }
        return redirect('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}

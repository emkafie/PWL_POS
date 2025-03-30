<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginOrRegister(Request $request)
    {
        // Cek apakah ada parameter 'action' di URL
        if ($request->has('action') && $request->action === 'register') {
            // Jika 'action' adalah 'register', arahkan ke halaman registrasi
            $levels = \App\Models\LevelModel::all();
            return view('auth.register', compact('levels'));
        }

        // Default: arahkan ke halaman login
        return view('auth.login');
    }
    // Memproses data registrasi
    public function storeRegister(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:m_user,username',
            'nama' => 'required|string|max:255',
            'password' => 'required|string|min:|confirmed',
            'level_id' => 'required|exists:m_level,level_id', // Pastikan level_id valid
        ]);

        // Simpan data pengguna ke database
        UserModel::create([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => Hash::make($request->password), // Hash password
            'level_id' => $request->level_id,
        ]);

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
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

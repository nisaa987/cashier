<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RoleCheck;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // jika autentikasi berhasil...
            $request->session()->regenerate();
            //regenerasi session ID untuk mencegah serangan session fixation
            return redirect('home')->withAlert("Login Berhasil");
            //redirect ke halaman/home dengan pesan flash "login berhasil" halaman disesuaikan dengan aplikasi yang kamu buat.
        }

        return back()->withErrors(['email' => 'Login gagal'])->onlyInput('email');
        // jika gagal, kembalikan ke halaman sebelumnya dengan pesan error dan input email tetap terisi
    }

    public function logout(Request $request)
    {
        // method untuk proses logout pengguna

        Auth::logout();
        //log out pengguna dari sistem

        $request->session()->invalidate();
        // menghapus semua data session saat ini

        $request->session()->regenerateToken();
        // regenerasi token CSRF agar tidak reuse token lama

        return redirect('/login');
        // arahkan pengguna kembali ke halaman login
    }
}


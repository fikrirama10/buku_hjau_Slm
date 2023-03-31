<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }

    public function auth(Request $request)
    {
        $credential = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->username, 'password' => $request->password, 'aktif' => 1])) {
            $request->session()->regenerate();

            Alert::success('login berhasil', 'selamat datang ' . $request->username);
            return redirect(route('home'));

        }
        Alert::error('login gagal', 'Username tidak ada atau belum terverifikasi');
        return back()->withErrors('Error Login');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img('math')]);
    }
}

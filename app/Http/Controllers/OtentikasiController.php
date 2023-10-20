<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtentikasiController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    function authenticated(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $credentials = [
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->id_role == 6) {
                return redirect('tata-usaha/akun-siswa')->with('_token', Session::token());
            } elseif ($user->id_role == 5) {
                return redirect('guru-bk/dashboard')->with('_token', Session::token());
            } elseif ($user->id_role == 4) {
                return redirect('guru-piket/dashboard')->with('_token', Session::token());
            } elseif ($user->id_role == 3) {
                return redirect('pengurus-kelas/dashboard')->with('_token', Session::token());
            } elseif ($user->id_role == 2) {
                return redirect('wali-kelas/dashboard')->with('_token', Session::token());
            } elseif ($user->id_role == 1) {
                return redirect('siswa/dashboard')->with('_token', Session::token());
            }
        }

        return redirect()->back()->withErrors('Terdapat kesalahan Username atau Password')->withInput()->with('_token', Session::token());
    }

    public function logout()
    {
        Auth::logout();
        Session::regenerateToken();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtentikasiController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $user = Auth::user();
        $redirectMap = [
            6 => 'tata-usaha/dashboard',
            5 => 'guru-bk/dashboard',
            4 => 'guru-piket/dashboard',
            3 => 'pengurus-kelas/dashboard',
            2 => 'wali-kelas/dashboard',
            1 => 'siswa/dashboard',
        ];

        if (isset($redirectMap[$user->id_role])) {
            return redirect($redirectMap[$user->id_role]);
        }
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
            Session::regenerateToken();
            $redirectMap = [
                6 => 'tata-usaha/dashboard',
                5 => 'guru-bk/dashboard',
                4 => 'guru-piket/dashboard',
                3 => 'pengurus-kelas/dashboard',
                2 => 'wali-kelas/dashboard',
                1 => 'siswa/dashboard',
            ];

            if (isset($redirectMap[$user->id_role])) {
                smilify('success', 'Berhasil Login');
                return redirect($redirectMap[$user->id_role]);
            }
        }

        Session::regenerateToken();
        smilify('error', 'Gagal Login');
        return redirect()->back()->withInput();
    }


    public function logout()
    {
        Auth::logout();
        Session::regenerateToken();
        return redirect('/');
    }
}

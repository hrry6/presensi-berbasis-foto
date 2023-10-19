<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtentikasiController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        return view("Login.login");
    }

    /**
     * Melakukan otentikasi login.
     */
    public function authenticated()
    {
        //
    }

    /**
     * Melakukan fungsi logout
     */
    public function logout(Request $request)
    {
        //
    }
}


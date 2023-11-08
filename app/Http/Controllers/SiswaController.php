<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('siswa.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showPresensi()
    {
        $data = [
            'presensi' => DB::table('view_presensi')->get()
        ];
        return view('siswa.presensi', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }
}

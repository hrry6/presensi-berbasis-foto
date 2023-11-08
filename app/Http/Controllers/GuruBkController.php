<?php

namespace App\Http\Controllers;

use App\Models\GuruBk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuruBkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('guru-bk.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function showPresensi()
    {
        $data = [
            'presensi' => DB::table('view_presensi')->get()
        ];
        return view('guru-bk.presensi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(GuruBk $GuruBk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruBk $GuruBk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruBk $GuruBk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruBk $GuruBk)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\GuruPiket;
use Illuminate\Http\Request;

class GuruPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guru-piket.index');
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
    public function show(GuruPiket $GuruPiket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuruPiket $GuruPiket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuruPiket $GuruPiket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuruPiket $GuruPiket)
    {
        //
    }
}

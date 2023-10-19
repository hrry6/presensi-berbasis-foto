<?php

namespace App\Http\Controllers;

use App\Models\GuruBk;
use Illuminate\Http\Request;

class GuruBkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('guru-bk.index');
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

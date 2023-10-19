<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TataUsahaKesiswaaan;
use Illuminate\Http\Request;

class TataUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tata-usaha.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function showSiswa(Siswa $siswa)
    {
        $data = [
            'siswa' => $siswa
                    ->join('kelas','siswa.id_kelas','=','kelas.id_kelas')
                    ->join('jurusan','kelas.id_jurusan','=','jurusan.id_jurusan')->get()
        ];
        // dd($data);
        return view('tata-usaha.siswa', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createSiswa()
    {
        $data = [
            'akun' => Akun::all(),
            'kelas' => Kelas::all(),
            'jurusan' => Jurusan::all()
        ];
        return view('tata-usaha.tambah-siswa', $data);
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
    public function show(TataUsahaKesiswaaan $tataUsahaKesiswaaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TataUsahaKesiswaaan $tataUsahaKesiswaaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TataUsahaKesiswaaan $tataUsahaKesiswaaan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroySiswa(Request $request)
    {
        $id_siswa = $request->input('id_siswa');
        $aksi = Siswa::where('id_siswa', $id_siswa)->delete();
        if($aksi)
        {
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil di hapus'
            ];
        }else
        {
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal di hapus'
            ];
        }
        return response()->json($pesan);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Logs;
use App\Models\Siswa;
use App\Models\TataUsahaKesiswaaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function createSiswa(Kelas $kelas)
    {
        $waliKelas = $kelas->all();
        return view('tata-usaha.tambah-siswa', ["waliKelas" => $waliKelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSiswa(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'foto_siswa' => 'required'
        ]);

        $user = Auth::user();
        Auth::user();
        $data['pembuat'] = $user->id_role;
        $data['id_akun'] = $user->id_akun;


        if ($request->hasFile('file')) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        }

        if ($siswa->create($data)) {
            return redirect('tata-usaha/akun-siswa')->with('success', 'Data surat baru berhasil ditambah');
        }

        return back()->with('error', 'Data surat gagal ditambahkan');
    }

        /**
     * Store a newly created resource in storage.
     */
    public function editSiswa(Request $request, Kelas $kelas ,Siswa $siswa)
    {
        $waliKelas = [
            "siswa" => $siswa
                            ->kelas()
                            ->akun(),
        ];
        return view('tata-usaha.tambah-siswa',  $waliKelas);
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

        /**
     * Remove the specified resource from storage.
     */
    public function logs(Logs $logs)
    {
        $data = [
            'logs' => $logs->all()
        ];
        return view('tata-usaha.logs', $data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class WaliKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wali-kelas.index');
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
        return view('wali-kelas.siswa', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Kelas $kelas)
    {
        $waliKelas = $kelas->all();

        return view('wali-kelas.tambah-siswa', ["waliKelas" => $waliKelas]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'foto_siswa' => 'required'
        ]);
<<<<<<< HEAD
=======

>>>>>>> 93302df729a98fd426c57759939fc0aea8b604f4
        $user = Auth::user();
        Auth::user();
        $data['id_akun'] = $user->id_akun;

        if ($request->hasFile('file')) {
            $foto_file = $request->file('file');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        }

        if ($siswa->create($data)) {
            return redirect('wali-kelas/akun-siswa')->with('success', 'Data surat baru berhasil ditambah');
        }

        return back()->with('error', 'Data surat gagal ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Siswa $siswa, Kelas $kelas)
    {
        $siswaData = Siswa::where('id_siswa', $id)->first();
        $kelasData = $kelas->all();

        return view('wali-kelas.edit-siswa', [
            'siswa' => $siswaData,
            'kelas' => $kelasData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    { 

        $id_siswa = $request->input('id_siswa');

        $data = $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'foto_siswa' => 'required'
        ]);

        if ($id_siswa !== null) {
            if ($request->hasFile('file')) {
                $foto_file = $request->file('file');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('foto'), $foto_nama);

                $update_data = $siswa->where('id_siswa', $id_siswa)->first();
                File::delete(public_path('foto') . '/' . $update_data->file);

                $data['file'] = $foto_nama;
            }

            $dataUpdate = $siswa->where('id_siswa', $id_siswa)->update($data);

            if ($dataUpdate) {
                return redirect('wali-kelas/akun-siswa')->with('success', 'Data berhasil diupdate');
            }

        }

        return back()->with('error', 'Data gagal diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
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

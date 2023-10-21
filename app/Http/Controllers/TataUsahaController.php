<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Logs;
use App\Models\PengurusKelas;
use App\Models\Siswa;
use App\Models\TataUsaha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

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
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get()
        ];
        // dd($data);
        return view('tata-usaha.siswa', $data);
    }

    public function showPengurus(PengurusKelas $pengurus)
    {
        $data = [
            'pengurus' => $pengurus
                ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')->get()
        ];
        // dd($data);
        return view('tata-usaha.pengurus-kelas', $data);
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
     * Show the form for creating a new resource.
     */
    public function createPengurus(Siswa $siswa)
    {
        $siswa = $siswa->all();
        return view('tata-usaha.tambah-pengurus', ["siswa" => $siswa]);
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

        $data['pembuat'] = $user->id_role;
        $data['id_akun'] = $user->id_akun;


        if ($request->hasFile('file')) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        }

        if ($siswa->create($data)) {
            return redirect('tata-usaha/akun-siswa')->with('success', 'Data siswa baru berhasil ditambah');
        }

        return back()->with('error', 'Data siswa gagal ditambahkan');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updatePengurus(Request $request, PengurusKelas $pengurus)
    {   
        // dd($request);
        $id_pengurus = $request->input('id_pengurus');
        $data = $request->validate([
            'id_pengurus' => 'required',
            'jabatan' => 'required',
        ]);

        if ($pengurus->where('id_pengurus', $id_pengurus)->update($data)) {
            return redirect('/tata-usaha/akun-pengurus-kelas')->with('success', 'Data pengurus baru berhasil ditambah');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

    public function updateSiswa(Request $request, Siswa $siswa)
    { 

        $id_siswa = $request->input('id_siswa');

        $data = $request->validate([
            'nis' => 'sometimes',
            'nama_siswa' => 'sometimes',
            'id_kelas' => 'sometimes',
            'jenis_kelamin' => 'sometimes',
            'nomer_hp' => 'sometimes',
            'foto_siswa' => 'sometimes'
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
                return redirect('tata-usaha/akun-siswa')->with('success', 'Data berhasil diupdate');
            }

        }

        return back()->with('error', 'Data gagal diupdate');
    }


    
    /**
     * Display the specified resource.
     */
    public function show(TataUsaha $TataUsaha)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */

     public function editSiswa(Request $request, Kelas $kelas, Siswa $siswa)
     {
         $siswa = [
             "siswa" => $siswa->join("kelas","siswa.id_kelas","=","kelas.id_kelas")
                                ->join("akun", "siswa.id_akun","=","akun.id_akun")
                                ->first(),
            "kelas" => $kelas->get()
         ];
         return view('tata-usaha.edit-siswa',  $siswa);
     }
     
    public function editPengurus(Request $request, Kelas $kelas, PengurusKelas $pengurus)
    {
        $pengurus = [
            "pengurus" => $pengurus->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')
                        ->where('id_pengurus','=', $request->id)
                        ->first()
        ];
        // dd($pengurus);
        return view('tata-usaha.edit-pengurus',  $pengurus);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TataUsaha $TataUsaha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TataUsaha $TataUsaha)
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
        if ($aksi) {
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil di hapus'
            ];
        } else {
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
    public function destroyPengurus(Request $request)
    {
        $id_pengurus = $request->input('id_pengurus');
        $aksi = PengurusKelas::where('id_pengurus', $id_pengurus)->delete();
        if ($aksi) {
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil di hapus'
            ];
        } else {
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
            'logs' => $logs->all(),
            
        ];
        return view('tata-usaha.logs', $data);
    }
}

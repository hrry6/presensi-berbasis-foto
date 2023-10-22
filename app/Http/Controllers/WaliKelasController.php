<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
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

    public function showPengurus(PengurusKelas $pengurus)
    {
        $data = [
            'pengurus' => $pengurus
                ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')->get()
        ];
        // dd($data);
        return view('wali-kelas.pengurus-kelas', $data);
    }

    public function showPresensi(PresensiSiswa $presensi)
    {
        $data = [
            'presensi' => $presensi
                ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get()
        ];

        // dd($data);
        return view('wali-kelas.presensi', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createSiswa(Kelas $kelas)
    {
        $kelas = $kelas
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->get();
        return view('tata-usaha.tambah-siswa', ["kelas" => $kelas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createPengurus(Siswa $siswa)
    {
        $siswa = $siswa->all();
        return view('wali-kelas.tambah-pengurus', ["siswa" => $siswa]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeSiswa(Request $request, Siswa $siswa, Role $role)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'foto_siswa' => 'required',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_akun'] = $user->id_akun;
        if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        } else {
            return back()->with('error', 'File upload failed. Please select a valid file.');
        }

        if ($siswa->create($data)) {
            notify()->success('Data siswa telah ditambah', 'Success');
            return redirect('wali-kelas/akun-siswa');
        }

        return back()->with('error', 'Data surat gagal ditambahkan');
    }

    public function storePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
        $data = $request->validate([
            'id_siswa' => 'required',
            'jabatan' => 'required'
        ]);


        $user = Auth::user();
        $role_akun = $role->where('id_role',$user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;


        if ($pengurus->create($data)) {
            notify()->success('Data pengurus kelas telah ditambah', 'Success');
            return redirect('wali-kelas/akun-pengurus-kelas')->with('success', 'Data pengurus kelas berhasil ditambah');
        }

        return back()->with('error', 'Data pengurus kelas gagal ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editSiswa(Request $request, Kelas $kelas, Siswa $siswa)
    {
        $data = [
            "siswa" => $siswa->where('id_siswa', $request->id)
                ->join("kelas", "siswa.id_kelas", "=", "kelas.id_kelas")
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get()
        ];
        return view('wali-kelas.edit-siswa',  $data);
    }


    public function editPengurus(Request $request, Kelas $kelas, PengurusKelas $pengurus)
    {
        $pengurus = [
            "pengurus" => $pengurus->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')
                ->where('id_pengurus', '=', $request->id)
                ->first()
        ];
        // dd($pengurus);
        return view('tata-usaha.edit-pengurus',  $pengurus);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSiswa(Request $request, Siswa $siswa, Role $role)
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

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        if ($id_siswa !== null) {
            if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
                $foto_file = $request->file('foto_siswa');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('foto'), $foto_nama);

                $update_data = $siswa->where('id_siswa', $id_siswa)->first();
                File::delete(public_path('foto') . '/' . $update_data->file);

                $data['foto_siswa'] = $foto_nama;
            }

            $dataUpdate = $siswa->where('id_siswa', $id_siswa)->update($data);

            if ($dataUpdate) {
                return redirect('tata-usaha/akun-siswa')->with('success', 'Data berhasil diupdate');
            }
        }

        return back()->with('error', 'Data gagal diupdate');
    }


    public function updatePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
        // dd($request);
        $id_pengurus = $request->input('id_pengurus');
        $data = $request->validate([
            'id_pengurus' => 'required',
            'jabatan' => 'required',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($pengurus->where('id_pengurus', $id_pengurus)->update($data)) {
            return redirect('/tata-usaha/akun-pengurus-kelas')->with('success', 'Data pengurus baru berhasil ditambah');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroySiswa(Request $request, Role $role)
    {
        $id_siswa = $request->input('id_siswa');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $aksi = Siswa::where('id_siswa', $id_siswa)->update($data);
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

    public function logs(Logs $logs)
    {
        $data = [
            'logs' => $logs->all(),

        ];
        return view('wali-kelas.logs', $data);
    }

}

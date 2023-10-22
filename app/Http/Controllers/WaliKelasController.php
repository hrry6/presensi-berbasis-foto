<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Akun;
use App\Models\Logs;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\DB;
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

    public function showSiswa(Siswa $siswa, Akun $akun)
    {
        $data = $siswa
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->join('akun', 'siswa.id_akun', '=', 'akun.id_akun')
            ->leftjoin('role_akun', function ($join) {
                $join->on('akun.id_role', '=', 'role_akun.id_role')
                    ->where('akun.id_role', '=', 1);
            })
            ->select('siswa.*', 'akun.username', 'akun.password as password')
            ->get();

        // dd($data);
        return view('wali-kelas.siswa', ['siswa' => $data, 'akun' => $akun]);
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
        $data['id_akun'] = $user->id_akun;
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        // Menggunakan NIS untuk username
        $data['username'] = $data['nis'];

        // Menghasilkan password acak
        $data['password'] = random_int(100000, 999999);

        
        if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        }

        DB::beginTransaction();
        try {
            $siswaId = $siswa->create($data)->id_siswa;
            DB::statement("CALL CreateAkunSiswa(?, ?, ?)", [$siswaId, $data['username'], $data['password']]);
            DB::commit();
            // notify()->success('Data siswa telah ditambah', 'Success');
            return redirect('wali-kelas/akun-siswa');
        } catch (Exception $e) {
            DB::rollback();
            return back()->with('error', 'Data siswa gagal ditambahkan');
        }
    }

    public function storePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
        $data = $request->validate([
            'id_siswa' => 'required',
            'jabatan' => 'required'
        ]);


        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
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

    public function editPresensi(Request $request, Kelas $kelas, PresensiSiswa $presensi)
    {
        $statusKehadiran = ['Hadir', 'Izin', 'Alpha'];

        $data = [
            "presensi" => $presensi->where('id_presensi', $request->id)->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            "statusKehadiran" => $statusKehadiran,
        ];

        return view('wali-kelas.edit-presensi', $data);
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
                notify()->success('Data siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/akun-siswa');
            }
        }

        notify()->error('Data siswa telah gagal diperbarui', 'Error');
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
            notify()->success('Data pengurus kelas telah diperbarui', 'Success');
            return redirect('/wali-kelas/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

    public function updatePresensi(Request $request, PresensiSiswa $presensi, Role $role)
    {
        $id_presensi = $request->input('id_presensi');
        $id_siswa = $request->input('id_siswa');

        $data = $request->validate([
            'id_siswa' => 'required',
            'status_kehadiran' => 'required',
            'keterangan_lebih_lanjut' => 'sometimes',
            'foto_bukti' => 'sometimes|file',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_siswa'] = $id_siswa;

        if ($id_presensi !== null) {
            if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
                $foto_file = $request->file('foto_bukti');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('foto'), $foto_nama);

                $update_data = $presensi->where('id_presensi', $id_presensi)->first();
                File::delete(public_path('foto') . '/' . $update_data->file);

                $data['foto_bukti'] = $foto_nama;
            }

            $dataUpdate = $presensi->where('id_presensi', $id_presensi)->update($data);

            if ($dataUpdate) {
                notify()->success('Data presensi siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/presensi-siswa');
            }
        }

        return back()->with('error', 'Data presensi gagal diupdate');
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

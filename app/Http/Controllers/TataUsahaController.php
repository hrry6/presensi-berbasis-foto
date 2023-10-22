<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Guru;
use App\Models\GuruBk;
use App\Models\GuruPiket;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Logs;
use App\Models\PengurusKelas;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\TataUsaha;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TataUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalGuru = DB::select('SELECT CountTeachers() AS totalGuru')[0]->totalGuru;
        $totalGuruBk = DB::select('SELECT CountBkTeachers() AS totalGuruBk')[0]->totalGuruBk;
        $totalGuruPiket = DB::select('SELECT CountPiketTeachers() AS totalGuruPiket')[0]->totalGuruPiket;
        $totalKelas = DB::select('SELECT CountClasses() AS totalKelas')[0]->totalKelas;
        $totalPengurusKelas = DB::select('SELECT CountClassMembers() AS totalPengurusKelas')[0]->totalPengurusKelas;
        $totalWaliKelas = DB::select('SELECT CountWaliKelas() AS totalWaliKelas')[0]->totalWaliKelas;
        $totalSiswa = DB::select('SELECT CountTotalStudents() AS totalSiswa')[0]->totalSiswa;

        return view('tata-usaha.index', compact('totalGuru', 'totalGuruBk', 'totalGuruPiket', 'totalKelas', 'totalPengurusKelas', 'totalSiswa', 'totalWaliKelas'));
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

    public function showGuru(GuruBk $guru_bk, GuruPiket $guru_piket, Kelas $kelas)
    {
        $data = [
            'guruBK' => $guru_bk
                ->join('guru', 'guru_bk.id_guru', '=', 'guru.id_guru')->get(),
            'guruPiket' => $guru_piket
                ->join('guru', 'guru_piket.id_guru', '=', 'guru.id_guru')->get(),
            'kelas' => $kelas
                ->join('guru', 'kelas.id_wali_kelas', '=', 'guru.id_guru')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get(),
        ];
        // dd($data);
        return view('tata-usaha.guru', $data);
    }

    public function showPresensi()
    {
        $data = [
            'presensi' => DB::table('view_presensi')->get()
        ];
        // dd($data);
        return view('tata-usaha.presensi', $data);
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
        return view('tata-usaha.tambah-pengurus', ["siswa" => $siswa]);
    }

    public function createGuru(GuruBk $guru_bk, GuruPiket $guru_piket, Kelas $kelas)
    {
        $data = [
            'kelas' => $kelas->where('id_wali_kelas', null)
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get(),
        ];
        // dd($data);
        return view('tata-usaha.tambah-guru', $data);
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
            return redirect('tata-usaha/akun-siswa');
        }

        return back()->with('error', 'Data surat gagal ditambahkan');
    }

    public function storeGuru(Request $request, Role $role, Guru $guru, GuruPiket $guruPiket, GuruBk $guruBk, Kelas $kelas)
    {
        $data = $request->validate([
            'nama_guru' => 'required',
            'foto_guru' => 'required'
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_akun'] = $user->id_akun;

        if ($request->hasFile('foto_guru') && $request->file('foto_guru')->isValid()) {
            $foto_file = $request->file('foto_guru');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('foto'), $foto_nama);
            $data['foto_guru'] = $foto_nama;
        } else {
            return back()->with('error', 'File upload failed. Please select a valid file.');
        }

        $status = $request->input('status');
        if ($status == 'Guru BK') {
            DB::beginTransaction();
            try {

                DB::statement("CALL CreateGuruBK(?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role]);
                DB::commit();
                return redirect('tata-usaha/akun-guru');
            } catch (Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
        }
        if ($status == 'Guru Piket') {
            DB::beginTransaction();
            try {
                DB::statement("CALL CreateGuruPiket(?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role]);
                DB::commit();
                return redirect('tata-usaha/akun-guru');
            } catch (Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
        } else {
            DB::beginTransaction();
            try {
                DB::statement("CALL CreateWaliKelas(?,?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role, $request->input('status')]);
                DB::commit();
                return redirect('tata-usaha/akun-guru');
            } catch (Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
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
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;


        if ($pengurus->create($data)) {
            notify()->success('Data pengurus kelas telah ditambah', 'Success');
            return redirect('tata-usaha/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus kelas gagal ditambahkan');
    }



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
        return view('tata-usaha.edit-siswa',  $data);
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

    public function editGuru(Request $request, Kelas $kelas, Guru $guru, GuruBk $guruBk, GuruPiket $guruPiket)
    {
        $guru = [
            "guru" => $guru->where('id_guru', $request->id)->first(),
            "guruBk" => $guruBk->where('id_guru', $request->id)->first(),
            "guruPiket" => $guruPiket->where('id_guru', $request->id)->first(),
            'kelas' => $kelas->all()
        ];
        // dd($guru);
        return view('tata-usaha.edit-guru',  $guru);
    }

    /**
     * Store a newly created resource in storage.
     */
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
            return redirect('/tata-usaha/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

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
                return redirect('tata-usaha/akun-siswa')->with('success', 'Data berhasil diupdate');
            }
        }



        return back()->with('error', 'Data gagal diupdate');
    }

    public function updateGuru(Request $request, Guru $guru, Role $role, Kelas $kelas, GuruBk $guruBk, GuruPiket $guruPiket)
    {

        $id_guru = $request->input('id_guru');
        $data = $request->validate([
            'nama_guru' => 'sometimes',
            'foto_guru' => 'sometimes'
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        // dd($data);
        if ($id_guru !== null) {
            if ($request->hasFile('foto_guru') && $request->file('foto_guru')->isValid()) {
                $foto_file = $request->file('foto_guru');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('foto'), $foto_nama);
                $update_data = $guru->where('id_guru', $id_guru)->first();
                File::delete(public_path('foto') . '/' . $update_data->file);
                $data['foto_guru'] = $foto_nama;
            }

            if ($data) {
                $status = $request->input('status');

                if ($kelas->where('id_wali_kelas', $id_guru)->first()) {
                    $kelas->where('id_wali_kelas', $id_guru)->update(['id_wali_kelas' => null]);
                }
                if ($guruPiket->where('id_guru', $id_guru)->first()) {
                    $guruPiket->where('id_guru', $id_guru)->delete();
                }
                if ($guruBk->where('id_guru', $id_guru)->first()) {
                    $guruBk->where('id_guru', $id_guru)->delete();
                }

                $guru->where('id_guru', $id_guru)->update($data);

                if ($status != 'Guru BK' && $status != 'Guru Piket') {
                    $kelas->where('id_kelas', $status)->update(['id_wali_kelas' => $id_guru]);
                }
                if ($status == 'Guru BK') {
                    $guruBk->create(['id_guru' => $id_guru]);
                }
                if ($status == 'Guru Piket') {
                    $guruPiket->create(['id_guru' => $id_guru]);
                }

                return redirect('tata-usaha/akun-guru');
            }
        }



        return back()->with('error', 'Data gagal diupdate');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroyPengurus(Request $request, Role $role)
    {
        $id_pengurus = $request->input('id_pengurus');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $aksi = PengurusKelas::where('id_pengurus', $id_pengurus)->update($data);
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


    public function destroyGuru(Request $request, Role $role, Kelas $kelas, GuruPiket $guruPiket, GuruBk $guruBk)
    {
        $id_guru = $request->input('id_guru');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($kelas->where('id_wali_kelas', $id_guru)->first()) {
            $kelas->where('id_wali_kelas', $id_guru)->update(['id_wali_kelas' => null]);
        }
        if ($guruPiket->where('id_guru', $id_guru)->first()) {
            $guruPiket->where('id_guru', $id_guru)->delete();
        }
        if ($guruBk->where('id_guru', $id_guru)->first()) {
            $guruBk->where('id_guru', $id_guru)->delete();
        }

        $pembuat = Guru::where('id_guru', $id_guru)->update($data);
        $hapus_guru = Guru::where('id_guru', $id_guru)->delete();

        if ($pembuat || $hapus_guru) {
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

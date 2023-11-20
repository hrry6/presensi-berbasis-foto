<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Guru;
use App\Models\Logs;
use App\Models\Role;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WaliKelasController extends Controller
{
    public function index()
    {
        $user = Auth::user()->id_akun;

        $totalSiswa = DB::table('siswa')
            ->select(DB::raw('COUNT(*) as totalSiswa'))
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'guru.id_guru', '=', 'kelas.id_wali_kelas')
            ->where('guru.id_akun', $user)
            ->value('totalSiswa');

        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('wali-kelas.index', compact('totalSiswa', 'totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function detailProfil(Request $request, Guru $guru, Kelas $kelas)
    {
        $id_guru = $guru->where('id_akun', $request->id)->first()->id_guru;
        $data = [
            "guru" => $guru
                        ->join('akun', 'guru.id_akun', '=','akun.id_akun')
                        ->where('id_guru', $id_guru)->first(),
            'kelas' => $kelas
                        ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')                
                        ->where('id_wali_kelas', $id_guru)
                        ->orderBy('tingkatan')->get()
        ];
        // dd($data);
        return view('wali-kelas.detail-profil', $data);
    }
    public function showSiswa(Request $request)
    {
        $user = Auth::user()->id_akun;

        $filter = DB::table('view_siswa')
            ->join('kelas', 'view_siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'guru.id_guru', '=', 'kelas.id_wali_kelas')
            ->where('guru.id_akun', $user)
            ->where(function ($query) use ($request) {
                $query->where('nis', 'LIKE', "%$request->keyword%")
                    ->orWhere('view_siswa.nama_siswa', 'LIKE', "%$request->keyword%")
                    ->orWhere('view_siswa.jenis_kelamin', 'LIKE', "%$request->keyword%")
                    ->orWhere('view_siswa.tingkatan', 'LIKE', "%$request->keyword%")
                    ->orWhere('view_siswa.nama_jurusan', 'LIKE', "%$request->keyword%");
            });


        if ($request->filter_jenkel != null) {
            $filter->where("jenis_kelamin", $request->filter_jenkel);
        }

        if ($request->filter_tingkatan != null) {
            $filter->where("tingkatan", $request->filter_tingkatan);
        }

        if ($request->filter_jurusan != null) {
            $filter->where("jurusan.id_jurusan", $request->filter_jurusan);
        }

        $data = [
            'siswa' => $filter->get(),
        ];

        return view('wali-kelas.siswa', $data);
    }

    public function showPengurus(PengurusKelas $pengurus, Request $request)
    {
        $user = Auth::user()->id_akun;

        $filter = $pengurus
            ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->select('siswa.nama_siswa', 'siswa.status_jabatan', 'kelas.nama_kelas', 'siswa.id_siswa', 'siswa.nis', 'pengurus_kelas.id_pengurus')
            ->join('guru', 'guru.id_guru', '=', 'kelas.id_wali_kelas')
            ->where('guru.id_akun', $user)
            ->where(function ($query) {
                $query->where('siswa.status_jabatan', 'ketua_kelas')
                    ->orWhere('siswa.status_jabatan', 'wakil_kelas')
                    ->orWhere('siswa.status_jabatan', 'sekretaris');
            });

        if ($request->filled('keyword')) {
            $filter->where(function ($query) use ($request) {
                $query
                    ->where('siswa.nama_siswa', 'LIKE', "%$request->keyword%")
                    ->orWhere('siswa.nis', 'LIKE', "%$request->keyword%");
            });
        }

        if ($request->filter_jabatan != null) {
            $filter = $filter->where('status_jabatan', $request->filter_jabatan);
        }

        $data = [
            'pengurus' => $filter->get()
        ];

        return view('wali-kelas.pengurus-kelas', $data);
    }

    public function showPresensi(PresensiSiswa $presensi, Request $request)
    {

        $filter = $this->filterPresensi($request, $presensi);

        $data = [
            'presensi' => $filter
        ];
        return view('wali-kelas.presensi', $data);
    }

    public function detailSiswa(Request $request, Kelas $kelas, Siswa $siswa, PengurusKelas $pengurus)
    {
        $data = [
            "siswa" => $siswa->where('id_siswa', $request->id)
                ->join("kelas", "siswa.id_kelas", "=", "kelas.id_kelas")
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->first(),
            'pengurus' => $pengurus
                ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->where('siswa.id_siswa', $request->id)
                ->first()

        ];


        return view('wali-kelas.detail-siswa',  $data);
    }

    public function detailKelasPengurus(Request $request, Kelas $kelas, Siswa $siswa, PengurusKelas $pengurus)
    {
        $data = [
            "kelas" => $kelas
                ->join('siswa', 'kelas.id_kelas', '=', 'siswa.id_kelas')
                ->where('kelas.id_kelas', $request->id)
                ->get(),
        ];

        return view('wali-kelas.detail-pengurus-kelas', $data);
    }

    public function createPengurus(Siswa $siswa)
    {
        $user = Auth::user()->id_akun;

        $data = [
            'siswa' => $siswa
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->select('siswa.id_siswa', 'siswa.nama_siswa', 'akun.id_role')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('guru', 'guru.id_guru', '=', 'kelas.id_wali_kelas')
                ->leftJoin('pengurus_kelas', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->where('guru.id_akun', $user)
                ->whereNull('pengurus_kelas.jabatan')
                ->where(function ($query) {
                    $query->orWhere('siswa.status_jabatan', '=', 'ketua_kelas')
                        ->orWhere('siswa.status_jabatan', '=', 'wakil_kelas');
                })
                ->get()
        ];

        return view('wali-kelas.tambah-pengurus', $data);
    }

    public function storePengurus(Request $request, PengurusKelas $pengurus, Role $role, Akun $akun)
    {
        $data = $request->validate([
            'id_siswa' => 'required',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['jabatan'] = 'Pengurus Kelas';

        $createdPengurus = $pengurus->create($data);

        if ($createdPengurus) {
            $siswaId = $request->input('id_siswa');
            $akun->join('siswa', 'akun.id_akun', '=', 'siswa.id_akun')
                ->where('siswa.id_siswa', $siswaId)
                ->update(['akun.id_role' => 3]);

            notify()->success('Data pengurus kelas telah ditambah', 'Success');
            return redirect('wali-kelas/akun-pengurus-kelas')->with('success', 'Data pengurus kelas berhasil ditambah');
        }

        return back()->with('error', 'Data pengurus kelas gagal ditambahkan');
    }


    public function editSiswa(Request $request, Kelas $kelas, Siswa $siswa)
    {
        $jenisKelamin = ['laki-laki', 'perempuan'];
        $statusJabatan = ['sekretaris', 'ketua_kelas', 'wakil_kelas', 'bendahara', 'siswa'];

        $data = [
            "siswa" => $siswa->where('id_siswa', $request->id)
                ->join("kelas", "siswa.id_kelas", "=", "kelas.id_kelas")
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            'jenisKelamin' => $jenisKelamin,
            'statusJabatan' => $statusJabatan

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

        return view('wali-kelas.edit-pengurus',  $pengurus);
    }

    public function editPresensi(Request $request, Kelas $kelas, PresensiSiswa $presensi)
    {
        $statusKehadiran = ['hadir', 'izin', 'alpha'];

        $data = [
            "presensi" => $presensi->where('id_presensi', $request->id)->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            "statusKehadiran" => $statusKehadiran,
        ];

        return view('wali-kelas.edit-presensi', $data);
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
            'status_jabatan' => 'sometimes',
            'foto_siswa' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($id_siswa !== null) {
            if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
                $foto_file = $request->file('foto_siswa');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = Str::uuid() . '.' . $foto_extension;
                $foto_file->move(public_path('siswa'), $foto_nama);

                $update_data = $siswa->where('id_siswa', $id_siswa)->first();
                $old_file_path = public_path('siswa') . '/' . $update_data->foto_siswa;

                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }

                $data['foto_siswa'] = $foto_nama;
            }

            $dataUpdate = $siswa->where('id_siswa', $id_siswa)->update($data);

            if ($dataUpdate) {
                notify()->success('Data siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/akun-siswa')->with('success', 'Data berhasil diupdate');
            }
        }

        return back()->with('error', 'Data gagal diupdate');
    }


    public function updatePengurus(Request $request, PengurusKelas $pengurus, Role $role)
    {
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
            'keterangan' => 'sometimes',
            'foto_bukti' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_siswa'] = $id_siswa;

        if ($id_presensi !== null) {
            if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
                $foto_file = $request->file('foto_bukti');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = Str::uuid() . '.' . $foto_extension;
                $foto_file->move(public_path('presensi_bukti'), $foto_nama);


                $update_data = $presensi->where('id_presensi', $id_presensi)->first();
                $old_file_path = public_path('presensi_bukti') . '/' . $update_data->foto_bukti;

                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }

                $data['foto_bukti'] = $foto_nama;
            }

            $dataUpdate = $presensi->where('id_presensi', $id_presensi)->update($data);

            if ($dataUpdate) {
                notify()->success('Data presensi siswa telah diperbarui', 'Success');
                return redirect('wali-kelas/presensi-siswa');
            }
        }
        return back()->with('error', 'Data gagal diperbarui');
    }

    public function destroyPengurus(Request $request, Akun $akun)
    {
        $id_pengurus = $request->input('id_pengurus');

        $siswaId = PengurusKelas::where('id_pengurus', $id_pengurus)->value('id_siswa');

        $aksi = PengurusKelas::where('id_pengurus', $id_pengurus)->delete();

        if ($aksi) {
            $akun->join('siswa', 'akun.id_akun', '=', 'siswa.id_akun')
                ->where('siswa.id_siswa', $siswaId)
                ->update(['akun.id_role' => 1]);

            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil dihapus'
            ];
        } else {
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal dihapus'
            ];
        }

        return response()->json($pesan);
    }


    public function logs(Logs $logs)
    {
        $data = [
            'logs' => $logs::orderBy('id_log', 'desc')->get(),

        ];
        return view('wali-kelas.logs', $data);
    }

    private function filterPresensi(Request $request, PresensiSiswa $presensi)
    {
        $user = Auth::user()->id_akun;
        $filter = $presensi
            ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('guru', 'guru.id_guru', '=', 'kelas.id_wali_kelas')
            ->where('guru.id_akun', $user)
            ->where(function ($query) use ($request) {
                $query->where('nama_siswa', 'LIKE', "%$request->keyword%")
                    ->orwhere('tanggal', 'LIKE', "%$request->keyword%")
                    ->orwhere('status_kehadiran', 'LIKE', "%$request->keyword%")
                    ->orwhere('nama_kelas', 'LIKE', "%$request->keyword%");
            });

        if ($request->filter_tanggal != null) {
            $filter = $filter->where('tanggal', 'LIKE', "%$request->filter_tanggal%");
        }
        if ($request->filter_kehadiran != null) {
            $filter = $filter->where('status_kehadiran', $request->filter_kehadiran);
        }
        return $filter->get();
    }

    public function exportPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi);
        $pdf = PDF::loadView('wali-kelas.presensi-pdf', ['presensi' => $filter]);
        return $pdf->download('presensi.pdf');
    }
}

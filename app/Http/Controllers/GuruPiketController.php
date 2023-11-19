<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
use App\Models\Role;
use App\Models\Guru;
use App\Models\GuruBK;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class GuruPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('guru-piket.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function detailProfil(Request $request, Guru $guru)
    {
        $id_guru = $guru->where('id_akun', $request->id)->first()->id_guru;
        $data = [
            "guru" => $guru
            ->join('akun', 'guru.id_akun', '=','akun.id_akun')
            ->where('id_guru', $id_guru)->first()
        ];
        return view('guru-piket.detail-profil', $data);
    }

    public function showPresensi(Request $request, Jurusan $jurusan, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi);
        $data = [
            'presensi' => $filter,
            'jurusan' =>  $jurusan->get()
        ];
        return view('guru-piket.presensi', $data);
    }
    private function filterPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $presensi
                ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->where(function ($query) use ($request) {
                    $query->where('nama_siswa', 'LIKE', "%$request->keyword%")
                    ->orwhere('tanggal', 'LIKE', "%$request->keyword%")
                    ->orwhere('status_kehadiran', 'LIKE', "%$request->keyword%")
                    ->orwhere('tingkatan', 'LIKE', "%$request->keyword%")
                    ->orwhere('nama_jurusan', 'LIKE', "%$request->keyword%")
                    ->orwhere('nama_kelas', 'LIKE', "%$request->keyword%");
                });
        if($request->filter_tanggal != null)
        {
            $filter = $filter->where('tanggal','LIKE',"%$request->filter_tanggal%");
        }
        if($request->filter_kehadiran != null)
        {
            $filter = $filter->where('status_kehadiran',$request->filter_kehadiran);
        }
        if($request->filter_tingkatan != null)
        {
            $filter = $filter->where('tingkatan',$request->filter_tingkatan);
        }
        if($request->filter_jurusan != null)
        {
            $filter = $filter->where('nama_jurusan',$request->filter_jurusan);
        }
        return $filter->get();
    }


    public function showPengurus(PengurusKelas $pengurus, Jurusan $jurusan,Request $request)
    {
        $filter = $pengurus
                ->join('siswa', 'siswa.id_siswa', '=', 'pengurus_kelas.id_siswa')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->where(function ($query) use ($request) {
                    $query->where('nama_siswa', 'LIKE', "%$request->keyword%")
                        ->orWhere('nis', 'LIKE', "%$request->keyword%")
                        ->orWhere('jabatan', 'LIKE', "%$request->keyword%")
                        ->orWhere('nama_kelas', 'LIKE', "%$request->keyword%")
                        ->orWhere('tingkatan', 'LIKE', "%$request->keyword%");
                });

        if($request->filter_jabatan != null)
        {
            $filter = $filter->where('status_jabatan',$request->filter_jabatan );
        }

        if($request->filter_tingkatan != null)
        {
            $filter = $filter->where('tingkatan', $request->filter_tingkatan);
        }

        if($request->filter_jurusan != null)
        {
            $filter = $filter->where('jurusan.id_jurusan', $request->filter_jurusan);
        }

        $data = [
            'pengurus' => $filter->get(),
            'jurusan' => $jurusan->get()
        ];
        return view('guru-piket.pengurus-kelas', $data);
    }

    public function detailPengurus(Request $request, Siswa $siswa, PengurusKelas $pengurus)
    {
        $data = [
            'pengurus' => $pengurus
                            ->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')
                            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                            ->where('id_pengurus', $request->id)->first()
        ];
        
        return view('guru-piket.detail-pengurus', $data);
    }
    
    public function detailPresensi(Request $request, PresensiSiswa $presensi)
    {
        $data = [
            'presensi' => $presensi
            ->join('siswa', 'siswa.id_siswa', '=', 'presensi_siswa.id_presensi')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->where('id_presensi', $request->id)->first()
        ];
        // dd($data);
        return view('guru-piket.detail-presensi', $data);
    }

    public function editPresensi(Request $request, PresensiSiswa $presensi)
    {
        $statusKehadiran = ['hadir', 'izin', 'alpha'];

        $data = [
            "presensi" => $presensi->where('id_presensi', $request->id)->first(),
            "statusKehadiran" => $statusKehadiran,
        ];

        return view('guru-piket.edit-presensi', $data);
    }

    public function updatePresensi(Request $request, Role $role, PresensiSiswa $presensi)
    {
        $id_presensi = $request->input('id_presensi');

        $data = $request->validate([
            'status_kehadiran' => 'sometimes',
            'keterangan' => 'sometimes',
            'foto_bukti' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        if ($id_presensi !== null) {
            if ($request->hasFile('foto_bukti') && $request->file('foto_bukti')->isValid()) {
                $foto_file = $request->file('foto_bukti');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
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
                return redirect('guru-piket/presensi');
            }
        }
        return back()->with('error', 'Data gagal diperbarui');
    }

    public function exportPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi); 
        $pdf = PDF::loadView('presensi-pdf', ['presensi' => $filter]);
        return $pdf->download('presensi.pdf');
    }
}

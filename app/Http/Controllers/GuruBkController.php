<?php

namespace App\Http\Controllers;

use App\Models\GuruBk;
use App\Models\Jurusan;
use App\Models\PresensiSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class GuruBkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('guru-bk.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function showPresensi(Request $request, Jurusan $jurusan, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi);
        $data = [
            'presensi' => $filter,
            'jurusan' =>  $jurusan->get()
        ];
        return view('guru-bk.presensi', $data);
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

    public function exportPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->filterPresensi($request, $presensi); 
        $pdf = PDF::loadView('presensi-pdf', ['presensi' => $filter]);
        return $pdf->download('presensi.pdf');
    }
}
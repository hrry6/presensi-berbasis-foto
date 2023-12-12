<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Validasi;
use App\Models\PengurusKelas;
use App\Models\PresensiSiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PengurusKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user()->id_akun;

        $totalHadir = DB::table('presensi_siswa')
            ->select(DB::raw('COUNT(*) as totalHadir'))
            ->join('siswa', 'presensi_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->where('presensi_siswa.status_kehadiran', '=', 'Hadir')
            ->where('siswa.id_akun', $user)
            ->value('totalHadir');

        $totalIzin = DB::table('presensi_siswa')
            ->select(DB::raw('COUNT(*) as totalIzin'))
            ->join('siswa', 'presensi_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->where('presensi_siswa.status_kehadiran', '=', 'Izin')
            ->where('siswa.id_akun', $user)
            ->value('totalIzin');

        $totalAlpha = DB::table('presensi_siswa')
            ->select(DB::raw('COUNT(*) as totalAlpha'))
            ->join('siswa', 'presensi_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->where('presensi_siswa.status_kehadiran', '=', 'Alpha')
            ->where('siswa.id_akun', $user)
            ->value('totalAlpha');

        return view('pengurus-kelas.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    public function detailProfil(Request $request, PengurusKelas $pengurus)
    {
        $id_pengurus = $pengurus->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')->where('id_akun', $request->id)->first()->id_pengurus;
        $data = [
            'pengurus' => $pengurus
                ->join('siswa', 'pengurus_kelas.id_siswa', '=', 'siswa.id_siswa')
                ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->where('id_pengurus', $id_pengurus)->first()
        ];
        // dd($data);
        return view('pengurus-kelas.detail-profil', $data);
    }

    public function openCam(Siswa $siswa)
    {
        $user = Auth::user()->id_akun;
        $siswaData = $siswa
            ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
            ->where('siswa.id_akun', $user)
            ->first();

        return view('pengurus-kelas.presensi', ['siswa' => $siswaData]);
    }

    public function showKelas(Request $request, Siswa $siswa, Validasi $validasi)
    {
        $siswa = $siswa
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('akun', 'siswa.id_akun', '=', 'akun.id_akun')
            ->where('akun.id_akun', Auth::user()->id_akun)
            ->first();

        $waktuValidasi = $request->input('waktu_validasi');

        $filter = $this->getKelasData($siswa, $validasi, $waktuValidasi);

        if ($filter->isNotEmpty()) {
            return view('pengurus-kelas.kelas', ['data' => $filter]);
        }

        return view('pengurus-kelas.kelas', ['data' => collect([])]);
    }

    public function exportKelas(Request $request, PresensiSiswa $presensi, Siswa $siswa, Validasi $validasi)
    {
        $siswa = $siswa
            ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
            ->join('akun', 'siswa.id_akun', '=', 'akun.id_akun')
            ->where('akun.id_akun', Auth::user()->id_akun)
            ->first();

        $waktuValidasi = $request->input('waktu_validasi');

        $filter = $this->getKelasData($siswa, $validasi, $waktuValidasi);

        // Remove duplicates based on id_presensi
        $filter = collect($filter)->unique('id_presensi')->values()->all();

        $pdf = PDF::loadView('pengurus-kelas.kelas-pdf', ['kelas' => $filter]);
        return $pdf->download('kelas.pdf');
    }

    private function getKelasData($siswa, $validasi, $waktuValidasi)
    {
        return $validasi
            ->join('presensi_siswa', 'validasi.id_presensi', '=', 'presensi_siswa.id_presensi')
            ->join('siswa', 'presensi_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->join('akun', 'siswa.id_akun', '=', 'akun.id_akun')
            ->where('siswa.id_kelas', $siswa->id_kelas)
            ->where(function ($query) use ($waktuValidasi) {
                $query->where('validasi.waktu_validasi', $waktuValidasi)
                    ->orWhere('validasi.waktu_validasi', 'istirahat_pertama')
                    ->orWhere('validasi.waktu_validasi', 'istirahat_kedua')
                    ->orWhere('validasi.waktu_validasi', 'istirahat_ketiga');
            })
            ->get();
    }

    public function updateValidasi(Request $request)
    {
        $request->validate([
            'waktu_validasi' => 'required',
        ]);

        foreach ($request->input('status_validasi') as $index => $statuses) {
            foreach ($statuses as $status) {
                $existingValidasi = Validasi::where('id_pengurus', $request->input("id_pengurus.$index"))
                    ->where('id_presensi', $request->input("id_presensi.$index"))
                    ->where('waktu_validasi', $request->input('waktu_validasi'))
                    ->first();

                if ($existingValidasi) {
                    $existingValidasi->update([
                        'status_validasi' => $status,
                    ]);
                }
            }
        }

        return back()->with('success', 'Data validasi sudah diupdate');
    }


    public function store(Request $request)
    {
        $image = $request->image;
        $folderPath = "presensi_bukti";

        list(, $imageData) = explode(";base64,", $image);
        $imageBase64 = base64_decode($imageData);

        $fileName = Str::uuid() . '.png';
        $filePath = public_path("$folderPath/$fileName");

        file_put_contents($filePath, $imageBase64);
        PresensiSiswa::create([
            'id_siswa' => $request->input('id_siswa'),
            'foto_bukti' => $fileName,
            'jam_masuk' => now('Asia/Jakarta')->format('H:i:s'),
            'tanggal' => now('Asia/Jakarta')->toDateString(),
            'status_kehadiran' => 'hadir',
            'keterangan' => 'Some description',
            'pembuat' => 'Siswa'

        ]);

        session(['snapshot_taken' => true]);

        return back()->with('success', 'Image uploaded successfully');
    }

    public function showHistori(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->getFilteredData($request, $presensi);

        $bulanList = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei',
            6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober',
            11 => 'November', 12 => 'Desember',
        ];

        $mingguList = [1, 2, 3, 4];
        $selectedMonth = $request->input('bulan', null);
        $selectedWeek = $request->input('minggu', null);

        return view('pengurus-kelas.histori', compact('filter', 'bulanList', 'mingguList', 'selectedMonth', 'selectedWeek'));
    }
    private function getFilteredData(Request $request, PresensiSiswa $presensi)
    {
        $selectedMonth = $request->input('bulan', null);
        $selectedWeek = $request->input('minggu', null);

        return $presensi::selectRaw("*, 
            CASE
                WHEN DAY(tanggal) <= 7 THEN 'Minggu ke-1'
                WHEN DAY(tanggal) <= 14 THEN 'Minggu ke-2'
                WHEN DAY(tanggal) <= 21 THEN 'Minggu ke-3'
                ELSE 'Minggu ke-4'
            END AS minggu")
            ->join('siswa', 'presensi_siswa.id_siswa', '=', 'siswa.id_siswa')
            ->where('siswa.id_akun', Auth::user()->id_akun)
            ->when($selectedMonth, function ($query, $selectedMonth) {
                $query->whereMonth('tanggal', $selectedMonth);
            })
            ->when($selectedWeek, function ($query, $selectedWeek) {
                $query->whereRaw("
                    CASE
                        WHEN DAY(tanggal) > 21 AND ? = 4 THEN 1
                        WHEN DAY(tanggal) > 14 AND ? = 3 THEN 1
                        WHEN DAY(tanggal) > 7 AND ? = 2 THEN 1
                        WHEN DAY(tanggal) <= 7 AND ? = 1 THEN 1
                        ELSE 0
                    END = 1
                ", [$selectedWeek, $selectedWeek, $selectedWeek, $selectedWeek]);
            })
            ->get();
    }

    public function exportPresensi(Request $request, PresensiSiswa $presensi)
    {
        $filter = $this->getFilteredData($request, $presensi);

        $pdf = PDF::loadView('pengurus-kelas.presensi-pdf', ['presensi' => $filter]);
        return $pdf->download('presensi.pdf');
    }
}

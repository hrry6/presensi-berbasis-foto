<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\PresensiSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalHadir = DB::select("SELECT CountStatus('Hadir') as totalHadir")[0]->totalHadir;
        $totalIzin = DB::select("SELECT CountStatus('Izin') as totalIzin")[0]->totalIzin;
        $totalAlpha = DB::select("SELECT CountStatus('Alpha') as totalAlpha")[0]->totalAlpha;

        return view('siswa.index', compact('totalHadir', 'totalIzin', 'totalAlpha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showPresensi()
    {
        $data = [
            'presensi' => DB::table('view_presensi')->get()
        ];
        return view('siswa.presensi', $data);
    }

    public function checkSnapshot(Request $request)
    {
        $id_siswa = $request->input('id_siswa');
        $exists = PresensiSiswa::where('id_siswa', $id_siswa)
            ->whereDate('created_at', today())
            ->exists();

        return response()->json(['exists' => $exists]);
    }


    public function openCam(Siswa $siswa)
    {
        $user = Auth::user()->id_akun;

        $data = [
            'siswa' => $siswa
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->where('siswa.id_akun', $user)
                ->first()
        ];


        // dd($data);
        return view('siswa.presensi', $data);
    }



    public function store(Request $request)
    {
        $img = $request->image;
        $folderPath = "presensi_bukti";

        $image_parts = explode(";base64,", $img);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = Str::uuid() . '.png';

        $filePath = public_path($folderPath . '/' . $fileName);

        file_put_contents($filePath, $image_base64);

        $presensiSiswa = new PresensiSiswa;
        $presensiSiswa->id_siswa = $request->input('id_siswa');
        $presensiSiswa->foto_bukti = $fileName;
        $presensiSiswa->jam_masuk = now('Asia/Jakarta')->format('H:i:s');
        $presensiSiswa->tanggal = now('Asia/Jakarta')->toDateString();
        $presensiSiswa->status_kehadiran = 'hadir';
        $presensiSiswa->keterangan = 'Some description';
        $presensiSiswa->pembuat = 'Siswa';
        $presensiSiswa->save();

        session(['snapshot_taken' => true]);

        return back()->with('success', 'Image uploaded successfully');
    }
}

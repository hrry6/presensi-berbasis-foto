<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\GuruBk;
use App\Models\GuruPiket;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Logs;
use App\Models\PengurusKelas;
use App\Models\Role;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class TataUsahaController extends Controller
{
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

    //Jurusan
    public function showJurusan(Jurusan $jurusan, Request $request)
    {
        $data = [
            'jurusan' => $jurusan->where('nama_jurusan','LIKE',"%$request->keyword%")->get()
        ];
        return view('tata-usaha.jurusan', $data);
    } 
    public function createJurusan()
    {
        return view('tata-usaha.tambah-jurusan');
    }

    public function storeJurusan(Jurusan $jurusan,Request $request)
    {
        $data = $request->validate([
            'nama_jurusan'=> 'required',
        ]);

        if($jurusan->create($data))
        {
            notify()->success('Data jurusan telah berhasil ditambahkan', 'Success');
            return redirect('tata-usaha/jurusan');
        }else
        {
            return back()->with('error', 'Data jurusan gagal ditambahkan');
        }
    }

    public function editJurusan(Jurusan $jurusan, Request $request)
    {
        $data = $jurusan->where('id_jurusan', $request->id)->first();
        return view('tata-usaha.edit-jurusan', ['data' => $data]);
    }

    public function updateJurusan(Jurusan $jurusan, Request $request)
    {
        $id_jurusan = $request->input('id_jurusan');
        $data = $request->validate([
            'nama_jurusan' => 'sometimes'
        ]); 
        // dd($request);
        
        if($jurusan->where('id_jurusan', $id_jurusan)->update($data))
        {
            notify()->success('Data jurusan telah berhasil diupdate', 'Success');
            return redirect('tata-usaha/jurusan');
        }else
        {
            return back()->with('error', 'Data jurusan gagal diupdate');
        }
    }

    public function destroyJurusan(Jurusan $jurusan, Request $request)
    {
        $id_jurusan = $request->input('id_jurusan');

        if($jurusan->where('id_jurusan', $id_jurusan)->delete())
        {
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil dihapus'
            ];
        }else
        {
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal dihapus'
            ];
        }
        return response()->json($pesan);
    }

    // Kelas
    public function showKelas(Kelas $kelas, Jurusan $jurusan, Request $request)
    {
        $filter = $kelas->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
        ->where(function ($query) use ($request) {
            $query->where('tingkatan', 'LIKE', "%$request->keyword%")
            ->orWhere('nama_jurusan', 'LIKE', "%$request->keyword%")
            ->orWhere('nama_kelas', 'LIKE', "%$request->keyword%")
            ->orWhere('status_kelas', 'LIKE', "%$request->keyword%");
        });
        // dd($request->filter_jurusan);
        if($request->filter_tingkatan != null) 
        {
            $filter = $filter->where("tingkatan", $request->filter_tingkatan);
        }

        if($request->filter_jurusan != null) 
        {
            $filter = $filter->where("jurusan.id_jurusan", $request->filter_jurusan);
        }

        if($request->filter_status != null) 
        {
            $filter = $filter->where('status_kelas', $request->filter_status);
        }

        $data = [
            'kelas' => $filter->get(),
            'jurusan' => $jurusan->get()
        ];
        return view('tata-usaha.kelas', $data);
    } 

    public function createKelas(Jurusan $jurusan)
    {
        return view('tata-usaha.tambah-kelas', ['jurusan' => $jurusan->get()]);
    }

    public function storeKelas(Kelas $kelas, Request $request)
    {
        $data = $request->validate([
            'tingkatan' => 'required',
            'id_jurusan' => 'required',
            'nama_kelas' => 'required',
            'status_kelas' => 'required'
        ]);
        
        if($kelas->create($data))
        {
            notify()->success('Data kelas telah berhasil ditambahkan', 'Success');
            return redirect('tata-usaha/kelas');
        }else
        {
            return back()->with('error', 'Data kelas gagal ditambahkan');
        }   
    }

    public function editKelas(Kelas $kelas,Jurusan $jurusan, Request $request)
    {
        $data = [
            'kelas' => $kelas->where('id_kelas', $request->id)->first(),
            'jurusan' => $jurusan->get()
        ];
        // dd($data);
        return view('tata-usaha.edit-kelas', $data);
    }

    public function updateKelas(Kelas $kelas,Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        $data = $request->validate([
            'tingkatan' => 'required',
            'id_jurusan' => 'required',
            'nama_kelas' => 'required',
            'status_kelas' => 'required'
        ]);
        if($kelas->where('id_kelas', $id_kelas)->update($data))
        {
            notify()->success('Data kelas telah berhasil diupdate', 'Success');
            return redirect('tata-usaha/kelas');
        }else
        {
            return back()->with('error', 'Data kelas gagal diupdate');
        }   
    }

    public function destroyKelas(Kelas $kelas,Request $request)
    {
        $id_kelas = $request->input('id_kelas');
        if($kelas->where('id_kelas', $id_kelas)->delete()){
            $pesan = [
                'success' => true,
                'pesan' => 'Data berhasil dihapus'
            ];
        }else
        {
            $pesan = [
                'success' => false,
                'pesan' => 'Data gagal dihapus'
            ];
        }
        return response()->json($pesan);
    }

    // GURU
    public function showGuru(GuruBk $guru_bk, GuruPiket $guru_piket, Kelas $kelas, Request $request)
    {
        if($request->keyword == null && $request->filter_status == null)
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
        }else
        {
            if( $request->filter_status == null)
            {
                $data = [
                    'guruBK' => $guru_bk
                        ->join('guru', 'guru_bk.id_guru', '=', 'guru.id_guru')->where('nama_guru', 'LIKE', "%$request->keyword%")->get(),
                    'guruPiket' => $guru_piket
                        ->join('guru', 'guru_piket.id_guru', '=', 'guru.id_guru')->where('nama_guru', 'LIKE', "%$request->keyword%")->get(),
                    'kelas' => $kelas
                        ->join('guru', 'kelas.id_wali_kelas', '=', 'guru.id_guru')
                        ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->where('nama_guru', 'LIKE', "%$request->keyword%")->get(),
                ];
            }
            if( $request->filter_status == "1")
            {
                $data = [
                    'guruBK' => $guru_bk
                        ->join('guru', 'guru_bk.id_guru', '=', 'guru.id_guru')->where('nama_guru', 'LIKE', "%$request->keyword%")->get()
                ];
            }
            if( $request->filter_status == "2")
            {
                $data = [
                    'guruPiket' => $guru_piket
                        ->join('guru', 'guru_piket.id_guru', '=', 'guru.id_guru')->where('nama_guru', 'LIKE', "%$request->keyword%")->get()
                ];
            }
            if( $request->filter_status == "3")
            {
                $data = [
                    'kelas' => $kelas
                        ->join('guru', 'kelas.id_wali_kelas', '=', 'guru.id_guru')
                        ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->where('nama_guru', 'LIKE', "%$request->keyword%")->get()
                ];
            }
        }
        // dd($data);
        return view('tata-usaha.guru', $data);
    }
    

    public function createGuru(GuruBk $guru_bk, GuruPiket $guru_piket, Kelas $kelas)
    {
        $data = [
            'kelas' => $kelas->where('id_wali_kelas', null)
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')->get(),
        ];
        return view('tata-usaha.tambah-guru', $data);
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
            $foto_file->move(public_path('guru'), $foto_nama);
            $data['foto_guru'] = $foto_nama;
        } else {
            return back()->with('error', 'File upload failed. Please select a valid file.');
        }

        $status = $request->input('status');
        if ($status == 'Guru BK') {
            $sukses = DB::statement("CALL CreateGuruBK(?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role]);
            if ($sukses) {
                notify()->success('Data guru telah berhasil ditambahkan', 'Success');
                return redirect('tata-usaha/akun-guru');
            } else {
                return back()->with('error', 'Data guru gagal ditambahkan');
            }
        }
        if ($status == 'Guru Piket') {
            $sukses = DB::statement("CALL CreateGuruPiket(?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role]);
            if ($sukses) {
                notify()->success('Data guru telah berhasil ditambahkan', 'Success');
                return redirect('tata-usaha/akun-guru');
            } else {
                return back()->with('error', 'Data guru gagal ditambahkan');
            }
        } else {
            $sukses = DB::statement("CALL CreateWaliKelas(?,?,?,?,?)", [$user->id_akun, $data['nama_guru'], $foto_nama, $role_akun->nama_role, $request->input('status')]);
            if ($sukses) {
                notify()->success('Data guru telah berhasil berhasil ditambahkan', 'Success');
                return redirect('tata-usaha/akun-guru');
            } else {
                return back()->with('error', 'Data guru gagal ditambahkan');
            }
        }
    }

    public function editGuru(Request $request, Kelas $kelas, Guru $guru, GuruBk $guruBk, GuruPiket $guruPiket)
    {
        $guru = [
            "guru" => $guru->where('id_guru', $request->id)->first(),
            "guruBk" => $guruBk->where('id_guru', $request->id)->first(),
            "guruPiket" => $guruPiket->where('id_guru', $request->id)->first(),
            'kelas' => $kelas->all()
        ];
        return view('tata-usaha.edit-guru',  $guru);
    }


    public function updateGuru(Request $request, Guru $guru, Role $role, Kelas $kelas, GuruBk $guruBk, GuruPiket $guruPiket)
    {
        $id_guru = $request->input('id_guru');
        $data = $request->validate([
            'nama_guru' => 'sometimes',
            'foto_guru' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($id_guru !== null) {
            if ($request->hasFile('foto_guru') && $request->file('foto_guru')->isValid()) {
                $foto_file = $request->file('foto_guru');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
                $foto_file->move(public_path('guru'), $foto_nama);
                $update_data = $guru->where('id_guru', $id_guru)->first();
    
                $old_file_path = public_path('guru') . '/' . $update_data->foto_guru;
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
    
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
                notify()->success('Data guru telah berhasil diupdate', 'Success');
                return redirect('tata-usaha/akun-guru');
            }
        }

        return back()->with('error', 'Data gagal diupdate');
    }

    public function destroyGuru(Request $request, Role $role, Kelas $kelas, GuruPiket $guruPiket, GuruBk $guruBk)
    {
        $id_guru = $request->input('id_guru');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        $guru = Guru::where('id_guru', $id_guru)->first();

        if ($guru) {
            if ($kelas->where('id_wali_kelas', $id_guru)->first()) {
                $kelas->where('id_wali_kelas', $id_guru)->update(['id_wali_kelas' => null]);
            }
            if ($guruPiket->where('id_guru', $id_guru)->first()) {
                $guruPiket->where('id_guru', $id_guru)->delete();
            }
            if ($guruBk->where('id_guru', $id_guru)->first()) {
                $guruBk->where('id_guru', $id_guru)->delete();
            }

            $pembuat = $guru->update($data);
            $hapus_guru = $guru->delete();

            $filePath = public_path('guru') . '/' . $guru->foto_guru;

            if (file_exists($filePath) && unlink($filePath)) {
                return response()->json(['success' => true]);
            }

            if ($pembuat || $hapus_guru) {
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
        } else {
            $pesan = [
                'success' => false,
                'pesan' => 'Guru tidak ditemukan'
            ];
        }

        return response()->json($pesan);
    }
    
    //PENGURUS KELAS 
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
        return view('tata-usaha.pengurus-kelas', $data);
    }

    public function createPengurus(Siswa $siswa)
    {
        $siswa = $siswa->all();
        return view('tata-usaha.tambah-pengurus', ["siswa" => $siswa]);
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
            notify()->success('Data pengurus kelas telah berhasil ditambahkan', 'Success');
            return redirect('tata-usaha/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus kelas gagal ditambahkan');
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
            notify()->success('Data pengurus kelas telah berhasil diupdate', 'Success');
            return redirect('/tata-usaha/akun-pengurus-kelas');
        }

        return back()->with('error', 'Data pengurus gagal ditambahkan');
    }

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
    // SISWA

    public function showSiswa(Siswa $siswa, Jurusan $jurusan,Request $request)
    {
        $filter = $siswa
        ->join('kelas', 'siswa.id_kelas', '=', 'kelas.id_kelas')
        ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
        ->where(function ($query) use ($request) {
            $query->where('nis', 'LIKE', "%$request->keyword%")
                ->orWhere('nama_siswa', 'LIKE', "%$request->keyword%")
                ->orWhere('jenis_kelamin', 'LIKE', "%$request->keyword%")
                ->orWhere('tingkatan', 'LIKE', "%$request->keyword%")
                ->orWhere('nama_jurusan', 'LIKE', "%$request->keyword%")
                ->orWhere('nama_kelas', 'LIKE', "%$request->keyword%");
        });

        if($request->filter_jenkel != null) {
            $filter->where("jenis_kelamin", $request->filter_jenkel);
        }

        if($request->filter_tingkatan != null) {
            $filter->where("tingkatan", $request->filter_tingkatan);
        }

        if($request->filter_jurusan != null) {
            $filter->where("jurusan.id_jurusan", $request->filter_jurusan);
        }

        $data = [
            'siswa' => $filter->get(),
            'jurusan' => $jurusan->get()
        ];
        // dd($data);
        return view('tata-usaha.siswa', $data);
    }

    public function createSiswa(Kelas $kelas, Siswa $siswa)
    {
        $jenisKelamin = ['laki-Laki', 'perempuan'];

        $kelas = $kelas
            ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
            ->get();
            
        $siswa->all();
        return view('tata-usaha.tambah-siswa', ["kelas" => $kelas, 'jenisKelamin' => $jenisKelamin, 'siswa' => $siswa]);
    }
    public function storeSiswa(Request $request, Siswa $siswa, Role $role)
    {
        $data = $request->validate([
            'nis' => 'required',
            'nama_siswa' => 'required',
            'id_kelas' => 'required',
            'jenis_kelamin' => 'required',
            'nomer_hp' => 'required',
            'angkatan' => 'required',
            'foto_siswa' => 'required',
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;
        $data['id_akun'] = $user->id_akun;
        if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
            $foto_file = $request->file('foto_siswa');
            $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_file->getClientOriginalExtension();
            $foto_file->move(public_path('siswa'), $foto_nama);
            $data['foto_siswa'] = $foto_nama;
        } else {
            return back()->with('error', 'File upload failed. Please select a valid file.');
        }

        if ($siswa->create($data)) {
            notify()->success('Data siswa telah berhasil ditambahkan', 'Success');
            return redirect('tata-usaha/akun-siswa');
        }

        return back()->with('error', 'Data surat gagal ditambahkan');
    }

    public function editSiswa(Request $request, Kelas $kelas, Siswa $siswa)
    {
        $jenisKelamin = ['Laki-Laki', 'Perempuan'];

        $data = [
            "siswa" => $siswa->where('id_siswa', $request->id)
                ->join("kelas", "siswa.id_kelas", "=", "kelas.id_kelas")
                ->join("akun", "siswa.id_akun", "=", "akun.id_akun")
                ->first(),
            "kelas" => $kelas
                ->join('jurusan', 'kelas.id_jurusan', '=', 'jurusan.id_jurusan')
                ->get(),
            'jenisKelamin' => $jenisKelamin,
            
        ];
        return view('tata-usaha.edit-siswa',  $data);
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
            'angkatan' => 'sometimes',
            'foto_siswa' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        if ($id_siswa !== null) {
            if ($request->hasFile('foto_siswa') && $request->file('foto_siswa')->isValid()) {
                $foto_file = $request->file('foto_siswa');
                $foto_extension = $foto_file->getClientOriginalExtension();
                $foto_nama = md5($foto_file->getClientOriginalName() . time()) . '.' . $foto_extension;
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
                notify()->success('Data siswa  telah berhasil diupdate', 'Success');
                return redirect('tata-usaha/akun-siswa')->with('success', 'Data berhasil diupdate');
            }
        }

        return back()->with('error', 'Data gagal diupdate');
    }

    public function destroySiswa(Request $request, Role $role)
    {
        $id_siswa = $request->input('id_siswa');
        $user = Auth::user();
        $role_akun = $role->where('id_role', $user->id_role)->first('nama_role');
        $data['pembuat'] = $role_akun->nama_role;

        $siswa = Siswa::where('id_siswa', $id_siswa)->first();

        if ($siswa) {
            $foto_siswa = $siswa->foto_siswa;

            $aksi = $siswa->delete();

            $filePath = public_path('siswa') . '/' . $foto_siswa;

            if (file_exists($filePath) && unlink($filePath)) {
                return response()->json(['success' => true]);
            }

            if ($aksi) {
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
        } else {
            $pesan = [
                'success' => false,
                'pesan' => 'Siswa not found'
            ];
        }

        return response()->json($pesan);
    }

    // PRESENSI
    public function showPresensi(Request $request, Jurusan $jurusan)
    {
        $filter = $this->filterPresensi($request);
        $data = [
            'presensi' => $filter,
            'jurusan' =>  $jurusan->get()
        ];
        // dd($data);
        return view('tata-usaha.presensi', $data);
    }

    private function filterPresensi(Request $request)
    {
        $filter = DB::table('view_presensi')
        ->where(function ($query) use ($request) {
            $query->where('nama_siswa', 'LIKE', "%$request->keyword%")
            ->orwhere('tanggal', 'LIKE', "%$request->keyword%")
            ->orwhere('status_kehadiran', 'LIKE', "%$request->keyword%")
            ->orwhere('tingkatan', 'LIKE', "%$request->keyword%")
            ->orwhere('jurusan', 'LIKE', "%$request->keyword%")
            ->orwhere('nama_kelas', 'LIKE', "%$request->keyword%");
        });
        if($request->filter_tanggal != null)
        {
            $filter = $filter->where('tanggal','LIKE',"%$request->filter_tanggal%" );
        }
        if($request->filter_kehadiran != null)
        {
            $filter = $filter->where('status_kehadiran',$request->filter_kehadiran );
        }
        if($request->filter_tingkatan != null)
        {
            $filter = $filter->where('tingkatan',$request->filter_tingkatan );
        }
        if($request->filter_jurusan != null)
        {
            $filter = $filter->where('jurusan',$request->filter_jurusan );
        }
        return $filter->get();
    }

    public function exportPresensi(Request $request)
    {
        $filter = $this->filterPresensi($request); 
        $pdf = PDF::loadView('presensi-pdf', ['presensi' => $filter]);
        // $pdf = PDF::loadView('presensi-pdf');
        return $pdf->download('presensi.pdf');
    }


    public function logs(Logs $logs, Request $request)
    {
        $filter = $logs::orderBy('id_log', 'desc')
        ->where(function ($query) use ($request) {
        $query->where('tabel', 'LIKE', "%$request->keyword%")
            ->orWhere('aktor', 'LIKE', "%$request->keyword%")
            ->orWhere('tanggal', 'LIKE', "%$request->keyword%")
            ->orWhere('jam', 'LIKE', "%$request->keyword%")
            ->orWhere('aksi', 'LIKE', "%$request->keyword%");
        })
        ->where('status', 'aktif');

        if($request->filter_tabel != null)
        {
            $filter = $filter->where('tabel',$request->filter_tabel );
        }

        if($request->filter_aktor != null)
        {
            $filter = $filter->where('aktor',$request->filter_aktor );
        }

        if($request->filter_tanggal != null)
        {
            $filter = $filter->where('tanggal',$request->filter_tanggal );
        }

        if($request->filter_aksi != null)
        {
            $filter = $filter->where('aksi',$request->filter_aksi );
        }

        $data = [
            'logs' => $filter->get()
        ];
        // dd($filter->get());
        return view('tata-usaha.logs', $data);
    }

    public function deleteLogs(Logs $logs, Request $request)
    {
        if($request->input('id_logs') != null)
        {
            foreach($request->id_logs as $p)
            {
                $logs::where('id_log', $p)->update(['status' => 'tidak_aktif']);    
            }
        }
        notify()->success('Data logs telah berhasil dihapus', 'Success');
        return redirect('/tata-usaha/logs')->with('success', 'Data logs berhasil dihapus');
    }
}

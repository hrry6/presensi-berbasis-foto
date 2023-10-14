<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['id_akun', 'id_kelas', 'nis', 'nama_siswa', 'nomer_hp', 'jenis_kelamin', 'foto_siswa'];
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;
}

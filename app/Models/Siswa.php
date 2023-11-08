<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['id_akun', 'id_kelas', 'nis', 'nama_siswa', 'nomer_hp', 'jenis_kelamin', 'foto_siswa', 'angkatan','pembuat'];
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;
}

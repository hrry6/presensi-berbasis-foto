<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiSiswa extends Model
{
    use HasFactory;
    protected $table = 'presensi_siswa';
    protected $fillable = ['id_siswa', 'foto_bukti', 'jam_masuk', 'tanggal', 'status_kehadiran'];
    protected $primaryKey = 'id_presensi';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validasi extends Model
{
    use HasFactory;
    protected $table = 'validasi';
    protected $fillable = ['id_pengurus', 'id_presensi', 'status_kehadiran', 'keterangan', 'waktu_validasi'];
    protected $primaryKey = 'id_validasi';
    public $timestamps = false;
}

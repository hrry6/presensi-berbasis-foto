<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['id_wali_kelas', 'id_jurusan', 'nama_kelas', 'tingkatan', 'status_kelas'];
    protected $primaryKey = 'id_kelas';
    public $timestamps = false;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengurusKelas extends Model
{
    use HasFactory;
    protected $table = 'pengurus_kelas';
    protected $fillable = ['id_siswa', 'jabatan'];
    protected $primaryKey = 'id_pengurus';
    public $timestamps = false;
}

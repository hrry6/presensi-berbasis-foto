<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $fillable = ['surat_keterangan'];
    protected $primaryKey = 'id_presensi';
    public $timestamps = false;
}

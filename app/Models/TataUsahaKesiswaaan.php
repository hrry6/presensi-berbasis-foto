<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TataUsahaKesiswaaan extends Model
{
    use HasFactory;
    protected $table = 'tata_usaha_kesiswaan';
    protected $fillable = ['id_akun', 'nama_kesiswaan', 'foto_kesiswaan'];
    protected $primaryKey = 'id_kesiswaan';
    public $timestamps = false;
}

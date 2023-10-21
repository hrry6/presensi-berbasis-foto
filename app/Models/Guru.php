<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = ['id_akun', 'nama_guru', 'foto_guru'];
    protected $primaryKey = 'id_guru';
    public $timestamps = false;

    // Get Attribute column
    public function getJenisSuratAttribute()
    {
        return Kelas::find($this->attributes['id_wali_kelas'])->wali_kelas;
    }
}

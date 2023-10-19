<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['id_akun', 'id_kelas', 'nis', 'nama_siswa', 'nomer_hp', 'jenis_kelamin', 'foto_siswa'];
    protected $primaryKey = 'id_siswa';
    public $timestamps = false;

    // One to One
    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    // One to One
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function getNamaKelasAttribute()
    {
        return Kelas::find($this->attributes['id_kelas'])->kelas;
    }
}

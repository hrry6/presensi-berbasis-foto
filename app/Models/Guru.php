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

    // One to One
    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    // One to One
    public function guruPiket(): HasOne
    {
        return $this->hasOne(GuruPiket::class, 'id_guru');
    }

    // One to One
    public function guruBk(): HasOne
    {
        return $this->hasOne(GuruBk::class, 'id_guru');
    }

    // Get Attribute column
    public function getJenisSuratAttribute()
    {
        return Kelas::find($this->attributes['id_wali_kelas'])->wali_kelas;
    }
}

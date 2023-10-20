<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TataUsaha extends Model
{
    use HasFactory;
    protected $table = 'tata_usaha';
    protected $fillable = ['id_akun', 'nama_kesiswaan', 'foto_kesiswaan'];
    protected $primaryKey = 'id_kesiswaan';
    public $timestamps = false;

    // One to One
    public function akun(): BelongsTo
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruPiket extends Model
{
    use HasFactory;
    protected $table = 'guru_piket';
    protected $fillable = ['id_guru'];
    protected $primaryKey = 'id_piket';
    public $timestamps = false;

    // One to One
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}

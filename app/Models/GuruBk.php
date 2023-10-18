<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruBk extends Model
{
    use HasFactory;
    protected $table = 'guru_bk';
    protected $fillable = ['id_guru'];
    protected $primaryKey = 'id_bk';
    public $timestamps = false;

    // One to One
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
}

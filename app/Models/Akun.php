<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    use HasFactory;
    protected $table = 'akun';
    protected $fillable = ['id_role', 'username', 'password'];
    protected $primaryKey = 'id_akun';
    public $timestamps = false;

    // One to One
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    // One to One
    public function TataUsaha(): HasOne
    {
        return $this->hasOne(User::class, 'id_akun');
    }

    // One to One
    public function guru(): HasOne
    {
        return $this->hasOne(User::class, 'id_akun');
    }

    // One to One
    public function siswa(): HasOne
    {
        return $this->hasOne(User::class, 'id_akun');
    }
}

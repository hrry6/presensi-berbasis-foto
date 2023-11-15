<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Akun extends Authenticatable
{
    use HasFactory;
    protected $table = 'akun';
    protected $fillable = ['id_role', 'username', 'password'];
    protected $primaryKey = 'id_akun';
    public $timestamps = false;
}

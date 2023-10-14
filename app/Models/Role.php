<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role_akun';
    protected $fillable = ['nama_role'];
    protected $primaryKey = 'id_role';
    public $timestamps = false;
}

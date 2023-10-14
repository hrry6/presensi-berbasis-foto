<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'guru';
    protected $fillable = ['id_akun', 'nama_guru', 'foto_guru'];
    protected $primaryKey = 'id_guru';
    public $timestamps = false;
}

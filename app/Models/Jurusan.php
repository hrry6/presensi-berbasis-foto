<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = ['nama_jurusan', 'pembuat'];
    protected $primaryKey = 'id_jurusan';
    public $timestamps = false;
}

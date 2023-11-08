<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $fillable = ['tabel', 'aktor', 'tanggal', 'jam', 'aksi', 'record', 'status'];
    protected $primaryKey = 'id_log';
    public $timestamps = false;
}

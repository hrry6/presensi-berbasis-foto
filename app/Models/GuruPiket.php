<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruPiket extends Model
{
    use HasFactory;
    protected $table = 'guru_piket';
    protected $fillable = ['id_guru'];
    protected $primaryKey = 'id_piket';
    public $timestamps = false;
}

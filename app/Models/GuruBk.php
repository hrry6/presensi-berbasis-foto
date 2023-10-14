<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruBk extends Model
{
    use HasFactory;
    protected $table = 'guru_bk';
    protected $fillable = ['id_guru'];
    protected $primaryKey = 'id_bk';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table        = 'petugas';
    protected $primarykey   = 'id_petugas';
    public $timestamps      = false;
    protected $fillable     = ['username', 'password', 'nama_petugas'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tunggakan extends Model
{
    protected $table        = 'tunggakan';
    protected $primarykey   = 'id_tunggakan';
    public $timestamps      = false;
    protected $fillable     = ['nisn', 'bulan_spp', 'tahun_spp', 'status'];
}

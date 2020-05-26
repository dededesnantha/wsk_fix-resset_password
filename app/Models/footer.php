<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class footer extends Model
{
    protected $table = 'footer';
    protected $fillable = ['posisi','judul','role','id_galeri_kategori']; 
}

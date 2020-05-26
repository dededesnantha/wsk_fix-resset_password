<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['id_parent','judul','seo_judul','seo_kata_kunci','seo_deskripsi','slug','gambar','status','position'];
}

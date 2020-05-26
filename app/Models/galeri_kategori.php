<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class galeri_kategori extends Model
{
    protected $table = 'galeri_kategori';
    protected $fillable = ['judul','seo_judul','seo_kata_kunci','seo_deskripsi','slug','gambar','status'];   
}

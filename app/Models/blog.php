<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    protected $table = 'blog';
    protected $fillable = ['id_blog_kategori','judul','gambar','deskripsi','status','seo_judul','seo_kata_kunci','seo_deskripsi','slug'];   
}

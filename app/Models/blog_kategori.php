<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog_kategori extends Model
{
 	protected $table = 'blog_kategori';
    protected $fillable = ['judul','id_parent','seo_judul','seo_kata_kunci','seo_deskripsi','slug'];   
}

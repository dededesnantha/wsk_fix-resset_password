<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id_kategori','judul','gambar','deskripsi','status','seo_judul','seo_kata_kunci','seo_deskripsi','slug','view','price'];
}

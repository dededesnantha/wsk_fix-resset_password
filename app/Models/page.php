<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class page extends Model
{
    protected $table = 'page';
    protected $fillable = ['judul','gambar','deskripsi','status','seo_judul','seo_kata_kunci','seo_deskripsi','slug','display'];
}

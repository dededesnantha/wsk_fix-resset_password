<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class profile_website extends Model
{
    protected $table = 'profile_website';
    protected $fillable = ['judul','deskripsi','logo','gambar','email','alamat','seo_judul','seo_kata_kunci','seo_deskripsi','google_webmaster','google_analytics','facebook_pixel','tripadvisor','map','tawk'];
}

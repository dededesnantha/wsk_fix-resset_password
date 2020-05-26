<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kontak extends Model
{
    protected $table = 'kontak';
    protected $fillable = ['judul','kontak','gambar','role'];
}

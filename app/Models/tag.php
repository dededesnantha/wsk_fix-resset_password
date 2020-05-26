<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tag extends Model
{
    protected $table = 'tag';
    protected $fillable = ['judul','seo_judul','seo_kata_kunci','seo_deskripsi','slug'];
}

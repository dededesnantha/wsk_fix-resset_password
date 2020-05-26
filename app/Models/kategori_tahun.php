<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori_tahun extends Model
{
    protected $table = 'kategori_tahun';
    protected $fillable = ['tahun','status'];
}

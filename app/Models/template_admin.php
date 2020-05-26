<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class template_admin extends Model
{
    protected $table = 'template_admin';
    protected $fillable = ['status','core','source'];
}

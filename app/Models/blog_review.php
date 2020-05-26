<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog_review extends Model
{
    protected $table = 'blog_review';
    protected $fillable = ['id_blog','count'];
}

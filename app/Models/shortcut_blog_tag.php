<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class shortcut_blog_tag extends Model
{
    protected $table = 'shortcut_blog_tag';
    protected $fillable = ['name','id_shortcut_blog_category'];
}

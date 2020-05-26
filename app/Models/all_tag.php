<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class all_tag extends Model
{
    protected $table = 'all_tag';
    protected $fillable = ['id_product','id_blog','id_tag'];
}

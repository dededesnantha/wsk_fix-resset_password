<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tag_review extends Model
{
    protected $table = 'tag_review';
    protected $fillable = ['id_tag','count'];
}

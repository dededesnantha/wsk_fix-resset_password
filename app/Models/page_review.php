<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class page_review extends Model
{
    protected $table = 'page_review';
    protected $fillable = ['id_page','count'];
}

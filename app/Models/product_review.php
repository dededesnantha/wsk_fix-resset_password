<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_review extends Model
{
    protected $table = 'product_review';
    protected $fillable = ['id_product','count'];
}

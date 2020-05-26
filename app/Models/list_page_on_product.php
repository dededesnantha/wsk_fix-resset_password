<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class list_page_on_product extends Model
{
    protected $table = 'list_page_on_product';
    protected $fillable = ['product_id','page_id','position'];
}

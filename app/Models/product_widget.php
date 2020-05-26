<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product_widget extends Model
{
    protected $table = 'product_widget';
    protected $fillable = ['widget_data_id','product_id','position'];
}

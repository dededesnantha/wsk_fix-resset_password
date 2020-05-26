<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class widget_data extends Model
{
    protected $table = 'widget_data';
    protected $fillable = ['widget_id','name','description'];
}

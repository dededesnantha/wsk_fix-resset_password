<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class template_color extends Model
{
    protected $table = 'template_color';
    protected $fillable = ['id_template','color','code_color','style','image'];
}

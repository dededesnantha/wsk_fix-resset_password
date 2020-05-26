<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class template_front extends Model
{
    protected $table = 'template_front';
    protected $fillable = ['id_template','custom_style','code_color'];
}

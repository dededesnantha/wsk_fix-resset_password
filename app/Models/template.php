<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class template extends Model
{
    protected $table = 'template';
    protected $fillable = ['name','status','source','version','image','style','default_style'];
}

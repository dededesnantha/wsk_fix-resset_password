<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class record_wa extends Model
{
    protected $table = 'record_wa';
    protected $fillable = ['ip','referer'];    
}

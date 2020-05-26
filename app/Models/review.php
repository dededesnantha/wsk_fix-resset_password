<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class review extends Model
{
    use SoftDeletes;

    protected $table = 'review';
    protected $fillable = ['subject','name','email','count','message','approve'];
    
    protected $dates = ['deleted_at'];
}

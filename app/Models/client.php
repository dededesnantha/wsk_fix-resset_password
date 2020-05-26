<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class client extends Model
{
	use SoftDeletes;
    protected $table = 'client';
    protected $fillable = ['name','domain','email','phone','wa','wechat','kakaotalk','viber','line','booking','status','image']; 
}
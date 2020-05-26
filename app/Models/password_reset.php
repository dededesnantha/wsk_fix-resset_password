<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class password_reset extends Model
{
	public $timestamps = false;
    protected $table = 'password_reset';
    protected $fillable = ['nis','token'];
}
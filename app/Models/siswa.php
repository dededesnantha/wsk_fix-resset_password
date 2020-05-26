<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
	public $timestamps = false;
    protected $table = 'siswa';
    protected $fillable = ['nis','password','name','device_id','kelas_id','api_token'];
}
<?php

namespace App\MOdels;

use Illuminate\Database\Eloquent\Model;

class log_action extends Model
{
    protected $table = 'log_action';
    protected $fillable = ['client_id','ip','contact','references']; 
}

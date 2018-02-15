<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telpextension extends Model
{
	
    protected $table = 'telpextension';
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

}

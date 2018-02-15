<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telpbiaya extends Model
{
	
    protected $table = 'telpbiaya';
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

}

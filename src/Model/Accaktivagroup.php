<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accaktivagroup extends Model
{
	    
    public $timestamps = false;
    protected $dates = ['deleted_at'];

}

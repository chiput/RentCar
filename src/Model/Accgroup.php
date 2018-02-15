<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Accgroup extends Model
{
	//use SoftDeletes;

    protected $table = 'accgroups';
    
    public $timestamps = false;

    //protected $dates = ['deleted_at'];

}

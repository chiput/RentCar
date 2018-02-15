<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Storegudang extends Model
{
	//use SoftDeletes;

    protected $table = 'storegudang';

	public $timestamps = false;


    //protected $dates = ['deleted_at'];
    
}

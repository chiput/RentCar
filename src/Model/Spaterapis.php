<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spaterapis extends Model
{
	    
  	use SoftDeletes;
    protected $table = 'spaterapis';
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }
    
}

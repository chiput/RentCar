<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Resmenu extends Model
{
	//use SoftDeletes;

    protected $table = 'resmenu';
    
    public function details(){
        return $this->hasMany('App\Model\Resmenudetail','id2','id');
    }
  
    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');
    }
    
}

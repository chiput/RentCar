<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reskasirkudetail extends Model
{
	//use SoftDeletes;
	
    protected $table = 'reskasirkudetail';

    public function menu(){
        return $this->hasOne('App\Model\Resmenu','id','menuid');
    }
    
    public function user(){

        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }
}

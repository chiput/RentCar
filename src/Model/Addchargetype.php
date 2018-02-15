<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Addchargetype extends Model
{
	
    
    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];

    public function acc_cost()
    {
    	return $this->hasOne('\App\Model\Account','id','acccost');
    }

    public function acc_income()
    {
    	return $this->hasOne('\App\Model\Account','id','accincome');
    }


}

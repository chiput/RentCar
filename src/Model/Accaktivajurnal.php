<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Accaktivajurnal extends Model
{
	
    
    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];

    public function detail()
    {
    	return $this->hasMany('App\Model\Accaktivajurnaldetail', 'accaktivajurnals_id', 'id');
    }


}

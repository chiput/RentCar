<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accaktivajurnaldetail extends Model
{
	
    
    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];

    public function aktiva()
    {
    	return $this->hasOne('App\Model\Accaktiva', 'id', 'accaktivas_id');
    }


}

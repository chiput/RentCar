<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Addchargedetail extends Model
{
	
    
    public $timestamps = false;
    
    public function addchargetype()
    {
    	return $this->hasOne('\App\Model\Addchargetype','id','addchargetypes_id');
    }

}

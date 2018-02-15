<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Acckastype extends Model
{
	
    protected $table = 'acckastypes';
    
    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];

    public function accdebet()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'accdebet_id');
    }

    public function acckredit()
    {
        return $this->hasOne('App\Model\Account', 'id', 'acckredit_id');
    }
    

}

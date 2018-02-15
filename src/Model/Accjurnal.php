<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accjurnal extends Model
{
	
    protected $table = 'accjurnals';
    
    public $timestamps = false;

    public function detail()
    {
    	return $this->hasMany('App\Model\Accjurnaldetail', 'Accjurnals_id', 'id');
    }

    public function user(){
    	return $this->hasOne('App\Model\User', 'id', 'users_id');

    }

}

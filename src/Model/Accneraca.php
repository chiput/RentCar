<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accneraca extends Model
{
	
    protected $table = 'accneracas';
    
    public $timestamps = false;

    public function detail()
    {
    	return $this->hasMany('App\Model\Accneracadetail', 'Accneracas_id', 'id');
    }

    public function user()
    {
    	return $this->hasOne('App\Model\User','id','users_id');
    }

    public function user_edit()
    {
    	return $this->hasOne('App\Model\User','id','users_id_edit');
    }

}

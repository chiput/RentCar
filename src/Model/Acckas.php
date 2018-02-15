<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acckas extends Model
{
	
    protected $table = 'acckas';
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

    public function details()
    {
    	return $this->hasMany('App\Model\Acckasdetail', 'acckas_id', 'id');
    }

    public function jurnal()
    {
        return $this->hasOne('App\Model\Accjurnal', 'id', 'accjurnals_id');
    }
    
    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }

    public function user_edit()
    {
        return $this->hasOne('\App\Model\User','id','users_id_edit');
    }

}

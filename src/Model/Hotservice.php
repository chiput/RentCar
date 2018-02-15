<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hotservice extends Model {
    protected $table = 'hotservice';
    public function service()
    {
      	return $this->hasMany('App\Model\Hotservicedetail2', 'id2', 'id');
    }
    public function barang()
    {
      	return $this->hasMany('App\Model\Hotservicebarang', 'id2', 'id');
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

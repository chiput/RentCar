<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudpindah extends Model
{
	
    protected $table = 'gudpindah';

    public function user(){
        return $this->hasOne('App\Model\User','id','users_id');
    }
    
    public function user_edit(){
        return $this->hasOne('App\Model\User','id','users_id_edit');
    }

    public function details()
    {
        return $this->hasMany('App\Model\Gudpindahdetail','gudpindah_id','id');
    }

    public function warehouseFrom()
    {
    	return $this->hasOne('\App\Model\Gudang','id','gudang_id1');
    }

    public function warehouseTo()
    {
    	return $this->hasOne('\App\Model\Gudang','id','gudang_id2');
    }
}

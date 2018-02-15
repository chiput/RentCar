<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudopname extends Model
{
	
    protected $table = 'gudopname';

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function user_edit()
    {
    	return $this->hasOne('\App\Model\User','id','users_id_edit');
    }

    public function details()
    {
        return $this->hasMany('App\Model\Gudopnamedetail','gudopname_id','id');
    }

    public function warehouse()
    {
    	return $this->hasOne('\App\Model\Gudang','id','gudang_id');
    }
}

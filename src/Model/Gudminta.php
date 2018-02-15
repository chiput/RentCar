<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudminta extends Model
{

    protected $table = 'gudminta';

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function user_edit()
    {
    	return $this->hasOne('\App\Model\User','id','users_id_edit');
    }

	public function pembelian()
    {
    	return $this->hasOne('\App\Model\Pembelian','permintaan_id','id');
    }

    public function details()
    {
        return $this->hasMany('App\Model\Gudmintadetail','gudminta_id','id');
    }

    public function department()
    {
    	return $this->hasOne('\App\Model\Department','id','department_id');
    }
}

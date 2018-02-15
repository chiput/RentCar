<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckOut extends Model {
    use SoftDeletes;

    public function guest()
    {
        return $this->hasOne('App\Model\Guest', 'id', 'guest_id');
    }

    public function details()
    {
        return $this->hasMany('App\Model\CheckOutDetail');
    }

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

}

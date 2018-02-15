<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hothilang extends Model {
    protected $table = 'hothilang';
    public function room()
    {
      return $this->belongsTo('App\Model\Reservationdetail', 'checkinid', 'checkin_code');
    }
    public function user(){
    	return $this->hasOne('App\Model\User','id','users_id');
    }
    public function user_edit(){
    	return $this->hasOne('App\Model\User','id','users_id_edit');
    }
    public function roomnya(){
    	return $this->hasOne('App\Model\Room', 'id','checkinid');
    }
}

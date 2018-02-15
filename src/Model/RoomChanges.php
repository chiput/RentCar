<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Reservationdetail;
use App\Model\Reservation;

class RoomChanges extends Model {
    //use SoftDeletes;

    public function details()
    {
        return $this->hasMany(Reservationdetail::class,'room_changes_id','id');
    }

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

}

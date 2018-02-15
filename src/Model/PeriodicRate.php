<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\PeriodicRateDetail;
use App\Model\BedType;
use App\Model\RoomType;

class PeriodicRate extends Model {

	public function details(){
    	return $this->hasMany('App\Model\PeriodicRateDetail', 'periodic_rates_id', 'id');
    }

    public function bedType(){
    	return $this->hasOne('App\Model\BedType', 'id', 'bed_types_id');
    }

    public function roomType(){
    	return $this->hasOne('App\Model\RoomType', 'id', 'room_types_id');
    }

}

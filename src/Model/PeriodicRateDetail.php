<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Room;
use App\Model\PeriodicRate;
class PeriodicRateDetail extends Model {

	public function room(){
    	return $this->hasOne('App\Model\Room', 'id', 'rooms_id');
    }

    public function rate(){
    	return $this->belongsTo('App\Model\PeriodicRate', 'periodic_rates_id', 'id');
    }

}

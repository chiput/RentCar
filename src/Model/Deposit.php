<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
	
    protected $table = 'deposits';

    public function bank(){

        return $this->hasOne('App\Model\Bank', 'id', 'banks_id');

    }

    public function user(){

        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }

    public function details(){

    	return $this->hasMany('App\Model\Reservationdetail', 'reservations_id', 'id');

    }

    public function room()
	{
    	return $this->hasOne('App\Model\Room', 'id', 'rooms_id');
    }

	public function reservation()
	{
		return $this->belongsTo('App\Model\Reservation', 'reservations_id', 'id');
	}

    
}

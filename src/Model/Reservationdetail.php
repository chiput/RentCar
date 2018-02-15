<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reservationdetail extends Model
{
    protected $table = 'reservationdetails';

    public function room()
	{
    	return $this->hasOne('App\Model\Room', 'id', 'rooms_id');
    }

	public function reservation()
	{
		return $this->belongsTo('App\Model\Reservation', 'reservations_id', 'id');
	}

    public function additional_charges()
    {
        return $this->hasMany('App\Model\Addcharge', 'reservationdetails_id', 'id');
    }

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');
    }

    public function user_edit(){
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');
    }

    public function checkoutDetails()
    {
        return $this->hasOne('App\Model\CheckOutDetail', 'reservation_detail_id', 'id');
    }
    public function agent($id)
    {
        return Agent::where('id','=',$id)
                      ->get();
    }
}

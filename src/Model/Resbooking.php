<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resbooking extends Model
{

    protected $table = 'resbooking';

    public function meja()
    {
        return $this->hasOne('App\Model\Resmeja','id','meja_id');
    }

    public function pelanggan()
    {
        return $this->hasOne('App\Model\Respelanggan','id','pelanggan_id');
    }
    
    public function reservationdetail()
    {
        return $this->hasOne('App\Model\Reservationdetail','id','rooms_id');
    }

    public function reservation()
    {
        return $this->belongsTo('App\Model\Reservation', 'reservations_id', 'id');
    }

    public function rooms()
    {
        return $this->belongsTo('App\Model\Room', 'id', 'rooms_id');
    }

    public function guest(){
        return $this->hasOne('App\Model\Guest', 'id', 'guests_id');
    }

    public function user()
    {
        return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function user_edit()
    {
        return $this->hasOne('\App\Model\User','id','users_id_edit');
    }
    
}

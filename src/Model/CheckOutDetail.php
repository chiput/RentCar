<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CheckOutDetail extends Model {

    public function reservationDetails()
    {
        return $this->hasOne('App\Model\Reservationdetail', 'id', 'reservation_detail_id');
    }

    public function checkout()
    {
        return $this->belongsTo('App\Model\CheckOut', 'check_out_id', 'id');
    }
}

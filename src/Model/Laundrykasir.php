<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Laundrykasir extends Model {
    protected $table = 'launkasir';
    public function room()
    {
      return $this->belongsTo('App\Model\Reservationdetail', 'checkinid', 'checkin_code');
    }
    public function detail()
    {
      return $this->hasMany('App\Model\Laundrydetail', 'id2', 'id');
    }
}

<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Laundry extends Model {
    protected $table = 'laundry';
    public function room()
    {
      return $this->belongsTo('App\Model\Reservationdetail', 'checkinid', 'checkin_code');
    }
    public function supplier()
    {
      return $this->belongsTo('App\Model\Supplier', 'supplierid', 'id');
    }
    public function detail()
    {
      return $this->hasMany('App\Model\Laundrydetail', 'id2', 'id');
    }
    public function kasir()
    {
      return $this->belongsTo('App\Model\Laundrykasir', 'id', 'id');
    }
}

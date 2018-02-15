<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hotpinjam extends Model {
    protected $table = 'hotpinjam';
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
    public function barang()
    {
      return $this->belongsTo('App\Model\Barang', 'barangid', 'id');
    }
    public function Reservationdetail()
    {
      return $this->belongsTo('App\Model\Reservationdetail', 'checkinid', 'checkin_code');
    }
    public function sewa()
    {
      return $this->belongsTo('App\Model\Hotjenispinjam', 'barangid', 'barangid');
    }
    public function kamar()
    {
      return $this->belongsTo('App\Model\Reservationdetail', 'checkinid', 'checkin_code');
    }
}

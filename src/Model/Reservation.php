<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
	
    protected $table = 'reservations';
    
    public $timestamps = false;

    public function details(){
    	return $this->hasMany('App\Model\Reservationdetail', 'reservations_id', 'id');
    }

    public function deposits(){
        return $this->hasMany('App\Model\Deposit', 'reservations_id', 'id');
    }

    public function guest(){
    	return $this->hasOne('App\Model\Guest', 'id', 'guests_id');
    }

    public function user(){
    	return $this->hasOne('App\Model\User', 'id', 'users_id');
    }

    public function user_edit(){
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');
    }

    public function agent(){
    	return $this->hasOne('App\Model\Agent', 'id', 'agent_id');
    }

    public function analisa_reservasi($date)
    {
        $convert = explode('-', $date);
        $convert = strlen($convert[0]);
        if($convert < 4){
            $date = $this->convert_date($date);
        }

        $pisah = explode("-", $date);

        $year = $pisah[0];
        $month = $pisah[1];

        $reservasi = Reservation::whereDate('tanggal','=',$date)->get()->count();
        
        return $reservasi;    
    }

    public function analisa_checkin($date)
    {
        $convert = explode('-', $date);
        $convert = strlen($convert[0]);
        if($convert < 4){
            $date = $this->convert_date($date);
        }

        $pisah = explode("-", $date);

        $year = $pisah[0];
        $month = $pisah[1];

        $reservasi = Reservation::whereDate('checkin','=',$date)->get()->count();
        
        return $reservasi;    
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}

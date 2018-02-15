<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Addcharge extends Model
{
    
    
    public $timestamps = false;
    
    //protected $dates = ['deleted_at'];

    public function reservation_detail()
    {
        return $this->hasOne('\App\Model\Reservationdetail','id','reservationdetails_id');
    }

    public function detail()
    {
        return $this->hasMany('\App\Model\Addchargedetail','addcharges_id','id');   
    }

    public function detailsatu()
    {
        return $this->hasOne('\App\Model\Addchargedetail','addcharges_id','id');   
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

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spakasir extends Model
{
	use SoftDeletes;
    protected $table = 'spakasir';

    //public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function terapis()
    {
        return $this->belongsTo('App\Model\Spaterapis','terapis_id' ,'id');
    }

    public function number($id)
    {
	    return Reservationdetail::join('rooms','reservationdetails.rooms_id','=','rooms.id')
	    					->select('rooms.number as number','reservationdetails.*')
	    					->where('reservationdetails.id','=',$id)
	                        ->get();
    }

    public function reservationdetail()
    {
        return $this->hasOne('App\Model\Reservationdetail', 'id', 'checkinid');
    }

    public function user(){

        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }

    public function user_edit(){
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');
    }
    
}

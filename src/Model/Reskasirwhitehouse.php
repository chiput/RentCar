<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reskasirwhitehouse extends Model
{
	use SoftDeletes;
    protected $table = 'reskasirwh';

    //public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function waiter()
    {
        return $this->belongsTo('App\Model\Reswaiter','waiters_id' ,'id');
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
}

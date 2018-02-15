<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\RoomType;
use App\Model\BedType;

class Room extends Model {
    use SoftDeletes;

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bedType()
    {
        return $this->belongsTo(BedType::class);
    }

    public function descriptions()
    {
        return $this->belongsToMany('App\Model\RoomDescription', 'room_rel_description', 'room_id', 'room_description_id');
    }

    public function reservationDetails()
    {
        return $this->hasMany('App\Model\Reservationdetail', 'rooms_id');
    }

    public function facilities()
    {
        return $this->hasMany('App\Model\RoomRelFacility', 'room_id');
    }

    public function building()
    {
        return $this->belongsTo('App\Model\Building','buildings_id' ,'id');
    }

    public function roomStatus()
    {
        return $this->belongsTo('App\Model\RoomStatus','id','rooms_id');
    }
    public function relfacilities()
    {
        return $this->belongsToMany('App\Model\RoomFacility', 'room_rel_facility', 'room_id', 'room_facility_id');
    }

    public function reservations($start, $end,$room)
    {
        $params["start"] = $start;
        $params["end"] = $end;

        if($start == $end){
            return Reservationdetail::whereHas('reservation',function($q) use($params){
                                $q->whereRaw("? between checkin and checkout",[$params["start"]]);
                            })
                            ->where('rooms_id','=',$room)
                            ->get();
        } else {
            return Reservationdetail::whereHas('reservation',function($q) use($params){
                                $q->where('checkin','<',$params["end"].' 00:00:00')
                                    ->where('checkout','>',$params["start"].' 00:00:00');
                            })
                            ->where('rooms_id','=',$room)
                            ->get();
        }
    }
    public function checkins($start, $end,$room)
    {
        $params["start"] = $start;
        $params["end"] = $end;

        if($start == $end){
            return Reservationdetail::orwherenotnull('checkin_code',null)
                            ->whereHas('reservation',function($q) use($params){
                                $q->whereRaw("? between checkin and checkout",[$params["start"]]);
                            })
                            ->where('rooms_id','=',$room)
                            ->get();
        } else {
            return Reservationdetail::orwherenotnull('checkin_code',null)
                            ->whereHas('reservation',function($q) use($params){
                                $q->where('checkin','<',$params["end"].' 00:00:00')
                                    ->where('checkout','>',$params["start"].' 00:00:00');
                            })
                            ->where('rooms_id','=',$room)
                            ->get();
        }
    }
}

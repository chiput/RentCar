<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Room;
use App\Model\RoomStatusType;

class RoomStatus extends Model {

    protected $table = 'room_status';

    public function type()
    {
    	return $this->hasOne('App\Model\RoomStatusType', 'id', 'status');
    }

    public function room()
    {
        return $this->belongsTo(Room::class,'id','rooms_id');
    }
    public function roomreport()
    {
        return $this->belongsTo(Room::class,'rooms_id','id');
    }
}

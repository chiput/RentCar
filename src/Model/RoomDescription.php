<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomDescription extends Model {
    use SoftDeletes;

    public function rooms()
    {
        return $this->belongsToMany('App\Model\Room', 'room_rel_description', 'room_description_id', 'room_id');
    }
}

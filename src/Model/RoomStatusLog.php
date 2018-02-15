<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RoomStatusLog extends Model {

    protected $table = 'room_status_log';

    public function user() {
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }

}

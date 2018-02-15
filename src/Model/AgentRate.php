<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Agent;
use App\Model\Room;
use App\Model\User;

class AgentRate extends Model
{
	
	public function room(){
		return $this->hasOne(Room::class,'id','room_id');
	}

	public function user(){
		return $this->hasOne(User::class,'id','users_id');
	}
    
}

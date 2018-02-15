<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model {

	public function action()
    {
    	return $this->hasOne('App\Model\ResourceAction', 'id', 'resource_action_id');
    }

}

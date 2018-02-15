<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResourceAction extends Model {

	protected $table = 'resource_actions';

	public function permissions()
    {
    	return $this->hasMany('App\Model\UserPermission', 'resource_action_id', 'id');
    }

}

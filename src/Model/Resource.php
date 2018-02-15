<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

	public function actions()
    {
    	return $this->hasMany('App\Model\ResourceAction', 'resource_id', 'id');
    }
}

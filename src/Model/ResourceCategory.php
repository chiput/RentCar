<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{

    protected $table = 'resource_categories';

    public function resources()
    {
    	return $this->hasMany('App\Model\Resource', 'resource_category_id', 'id');
    }
}

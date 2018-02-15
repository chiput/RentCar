<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function rooms()
    {
    	return $this->hasMany('App\Model\Room', 'buildings_id', 'id');
    }


}

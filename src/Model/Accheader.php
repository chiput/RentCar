<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accheader extends Model
{
	use SoftDeletes;
	
    protected $table = 'accheaders';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function accgroup()
    {
    	return $this->hasOne('App\Model\Accgroup', 'id', 'accgroups_id');	
    }

    public function accounts()
    {
    	return $this->hasMany('App\Model\Account', 'accheaders_id', 'id');	
    }

    
}

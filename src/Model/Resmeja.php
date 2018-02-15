<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resmeja extends Model
{
	
	use SoftDeletes;
    protected $table = 'resmeja';
	protected $dates = ['deleted_at'];
    

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }   
}

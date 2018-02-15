<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phonebook extends Model
{
	    
  	use SoftDeletes;
    protected $table = 'fronphonebook';
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }
    
}

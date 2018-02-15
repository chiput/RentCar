<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setupgudang extends Model
{

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }
}

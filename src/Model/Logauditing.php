<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Logauditing extends Model
{
    protected $table = 'logauditing';

    public $timestamps = false;

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }

}

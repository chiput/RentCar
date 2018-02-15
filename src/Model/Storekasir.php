<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storekasir extends Model
{
	use SoftDeletes;
    protected $table = 'storekasir';

    //public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function user(){

        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }

    public function user_edit(){
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');
    }
}

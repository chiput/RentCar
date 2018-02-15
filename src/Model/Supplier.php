<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
	use SoftDeletes;
    protected $table = 'suppliers';
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }
}

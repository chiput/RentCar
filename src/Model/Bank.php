<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
	
    protected $table = 'banks';

    public function account()
    {
    	return $this->hasOne('\App\Model\Account','id','accounts_id');
    }

    public function admin()
    {
    	return $this->hasOne('\App\Model\Account','id','accadmin');
    }

}

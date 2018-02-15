<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Spakasirdetail extends Model
{
	//use SoftDeletes;
	
    protected $table = 'spakasirdetail';

    public function layanan()
    {
        return $this->hasOne('App\Model\Spalayanan','id','layananid');
    }

    public function terapis()
    {
        return $this->hasOne('App\Model\Spaterapis','id' ,'terapisid');
    }

    public function user()
    {
        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }
    
    
}

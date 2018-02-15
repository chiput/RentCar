<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accaktiva extends Model
{
	
    protected $table = 'accaktivas';
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

    public function aktiva()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'accaktiva_id');
    }

    public function kas()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'acckas_id');
    }

    public function akumulasi()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'accakumulasi_id');
    }

    public function penyusutan()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'accpenyusutan_id');
    }

}

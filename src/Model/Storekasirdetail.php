<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Storekasirdetail extends Model
{
	//use SoftDeletes;
	
    protected $table = 'storekasirdetails';

    public function user(){

        return $this->hasOne('App\Model\User', 'id', 'users_id');

    }

    public function barang(){
    	return $this->hasOne('App\Model\Barang', 'id', 'barang_id');
    }

    public function store(){
    	return $this->hasOne('App\Model\Storebarang','barang_id','barang_id');
    }

    public function terpis(){
        return $this->hasOne('App\Model\Spaterapis','id','terapisid');
    }
}

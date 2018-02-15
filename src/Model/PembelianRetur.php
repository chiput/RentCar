<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianRetur extends Model
{
	 use SoftDeletes;
	 protected $table = 'pembelianretur';
	 protected $dates = ['deleted_at'];

	 public function user() {
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
     }

     public function user_edit() {
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');   
     }

     public function details()
     {
        return $this->hasMany('App\Model\PembelianReturDetail','pembelianretur_id','id');
     }

     public function purchase()
     {
        return $this->hasOne('App\Model\Pembelian','id','pembelian_id');
     }

     public function receive() {
        return $this->hasOne('App\Model\Gudterima', 'id', 'terima_id');   
     }
}
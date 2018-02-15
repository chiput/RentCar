<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PembelianReturDetail extends Model
{
	 protected $table = 'pembelianreturdetail';

	 public function pembelianretur() {
        return $this->hasOne('App\Model\PembelianRetur', 'id', 'pembelianretur_id');   
     }

     public function good() {
     	return $this->hasOne('App\Model\Barang', 'id', 'barang_id');  
     }

     public function unit() {
     	return $this->hasOne('App\Model\Brgsatuan', 'id', 'satuan_id');
     }  
}
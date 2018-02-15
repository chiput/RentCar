<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PembelianDetail extends Model
{
	 protected $table = 'pembeliandetail';

	public function good()
    {
        return $this->hasOne('App\Model\Barang','id','barang_id');
    }

    public function unit()
    {
        return $this->hasOne('App\Model\Brgsatuan','id','satuan_id');
    }

    public function retur()
    {
    	return $this->hasMany('App\Model\PembelianReturDetail','barang_id','barang_id');
    }

    public function order()
    {
    	return $this->hasMany('App\Model\PembelianDetail','barang_id','barang_id');
    }

    public function request()
    {
    	return $this->hasMany('App\Model\Gudmintadetail','barang_id','barang_id');
    }
}
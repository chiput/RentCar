<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudopnamedetail extends Model
{
	
    protected $table = 'gudopnamedetail';

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function stocktaking()
    {
    	return $this->hasOne('\App\Model\Gudminta','id','gudopname_id');
    }

    public function unit()
    {
    	return $this->hasOne('\App\Model\Brgsatuan','id','satuan_id');
    }

    public function good()
    {
    	return $this->hasOne('\App\Model\Barang','id','barang_id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudpindahdetail extends Model
{
	
    protected $table = 'gudpindahdetail';

    public function user()
    {
    	return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function gudpindah(){
        return $this->hasOne('App\Model\Gudpindah', 'id', 'gudpindah_id');
    }

    public function unit()
    {
    	return $this->hasOne('\App\Model\Brgsatuan','id','brgsatuan_id');
    }

    public function good()
    {
    	return $this->hasOne('\App\Model\Barang','id','barang_id');
    }


}

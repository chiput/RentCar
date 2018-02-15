<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storebarang extends Model
{
    protected $table = 'storebarang';

    //public $timestamps = false;

    public function detail(){
        return $this->hasOne('App\Model\Barang','id','barang_id');
    }  
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spalayanandetail extends Model
{
	use SoftDeletes;

    protected $table = 'spalayanandetail';

    public $timestamps = false;

    protected $dates = ['deleted_at'];
    
    public function barang(){
        return $this->hasOne('App\Model\Barang','id','barangid');
    }  
  

    
}

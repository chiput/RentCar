<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Spalayanan extends Model
{
	//use SoftDeletes;

    protected $table = 'spalayanan';
    
    public function details(){
        return $this->hasMany('App\Model\Spalayanandetail','id2','id');
    }
  
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Respesanan extends Model
{
	
    protected $table = 'respesanan';

    public function details(){
        return $this->hasMany('App\Model\Respesanandetail','id2','id');
    }
    
    
}

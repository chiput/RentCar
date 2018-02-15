<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Respesanandetail extends Model
{
	
    protected $table = 'respesanandetail';

    public function menu(){
        return $this->hasOne('App\Model\Resmenu','id','menuid');
    }
    
    
}

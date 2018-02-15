<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reskasirdetailwhitehouse extends Model
{
	
    protected $table = 'reskasirdetailwh';

    public function menu(){
        return $this->hasOne('App\Model\Resmenu','id','menuid');
    }
    
}

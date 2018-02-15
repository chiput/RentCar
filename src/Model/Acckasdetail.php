<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acckasdetail extends Model
{
	
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

    public function acckastype()
    {
        return $this->hasOne('App\Model\Acckastype', 'id', 'acckastypes_id');
    }
    

}

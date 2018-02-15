<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Option extends Model
{
	
    protected $table = 'options';
    
    public $timestamps = false;

    public function account(){
        return $this->hasOne('App\Model\Account', 'id', 'value');
    }
    
}

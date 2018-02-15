<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Accneracadetail extends Model
{
	
    protected $table = 'accneracadetails';
    
    public $timestamps = false;

    public function account()
    {
        return $this->hasOne('App\Model\Account', 'id', 'accounts_id');
    }
}

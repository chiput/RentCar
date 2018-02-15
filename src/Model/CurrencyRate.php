<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyRate extends Model
{
	
    protected $table = 'currency_rate';
    

    public function aktiva()
    {
    	return $this->hasOne('App\Model\Account', 'id', 'accaktiva_id');
    }

}

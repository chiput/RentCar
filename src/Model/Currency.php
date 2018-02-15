<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
	use SoftDeletes;
    protected $table = 'currency';
    

    public function rate()
    {
    	return $this->hasMany('App\Model\CurrencyRate', 'currency_id', 'id');
    }

}

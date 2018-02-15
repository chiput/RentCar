<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telpbilling extends Model
{
	
    protected $table = 'telpbilling';
    
    public $timestamps = false;
    
    protected $dates = ['deleted_at'];

}

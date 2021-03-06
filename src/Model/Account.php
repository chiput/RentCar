<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
	use SoftDeletes;

    protected $table = 'accounts';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brgsatuan extends Model
{
	use SoftDeletes;

    protected $table = 'brgsatuan';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    
}

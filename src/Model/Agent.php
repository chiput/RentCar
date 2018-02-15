<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
	use SoftDeletes;

    protected $table = 'agents';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    
}

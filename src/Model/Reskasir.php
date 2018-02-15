<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reskasir extends Model
{
	use SoftDeletes;
    protected $table = 'reskasir';

    public $timestamps = false;

    protected $dates = ['deleted_at'];
    
}

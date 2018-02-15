<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reskasirdetail extends Model
{
	use SoftDeletes;
    protected $table = 'reskasirdetail';

    public $timestamps = false;

    protected $dates = ['deleted_at'];
    
}

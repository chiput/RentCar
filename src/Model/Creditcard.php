<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Creditcard extends Model {
    //use SoftDeletes;

    public function bank(){
        return $this->hasOne('App\Model\Bank','id','banks_id');
    }
}

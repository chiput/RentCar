<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model {
    use SoftDeletes;

    public function rooms()
    {
        return $this->hasMany('App\Model\Room');
    }
}

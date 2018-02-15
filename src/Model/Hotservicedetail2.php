<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hotservicedetail2 extends Model {
    protected $table = 'hotservicedetail2';
    public function room()
    {
      return $this->hasOne('App\Model\Room', 'id', 'kamarid');
    }
}

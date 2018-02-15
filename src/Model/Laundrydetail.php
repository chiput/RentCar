<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Laundrydetail extends Model {
    protected $table = 'laundrydetail';
    public function tarif()
    {
      return $this->belongsTo('App\Model\Launtarif', 'tarifid', 'id');
    }
}

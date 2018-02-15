<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Launtarif extends Model {
    protected $table = 'launtarif';
    public function layanan()
    {
      return $this->belongsTo('App\Model\Launlayanan', 'layananid', 'id');
    }
}

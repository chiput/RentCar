<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hotservicebarang extends Model {
    protected $table = 'hotservicebarang';
    public function room()
    {
      return $this->belongsTo('App\Model\Room', 'kamarid', 'id');
    }
    public function barang()
    {
      return $this->belongsTo('App\Model\Barang', 'barangid', 'id');
    }
}

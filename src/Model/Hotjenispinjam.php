<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;

class Hotjenispinjam extends Model {
    protected $table = 'hotjenispinjam';
    public function barang()
    {
      return $this->belongsTo('App\Model\Barang', 'barangid', 'id');
    }
}

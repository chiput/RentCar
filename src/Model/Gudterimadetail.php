<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gudterimadetail extends Model
{

    protected $table = 'gudterimadetail';
    
    public function gudterima(){
        return $this->hasOne('App\Model\Gudterima', 'id', 'gudterima_id');
    }

    public function good(){
        return $this->hasOne('App\Model\Barang', 'id', 'barang_id');
    }

    public function unit(){
        return $this->hasOne('App\Model\Brgsatuan', 'id', 'satuan_id');
    }

    public function goodterima() {
        return $this->belongsTo('App\Model\Gudterima', 'gudterima_id', 'id');
    }

}

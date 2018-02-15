<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gudrevisidetail extends Model
{

    protected $table = 'gudrevisidetail';

    public function good(){
        return $this->hasOne('App\Model\Barang', 'id', 'barang_id');
    }

    public function unit(){
        return $this->hasOne('App\Model\Brgsatuan', 'id', 'satuan_id');
    }

    public function gudrevisi(){
        return $this->hasOne('App\Model\Gudrevisi', 'id', 'gudrevisi_id');
    }
    
}

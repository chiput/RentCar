<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gudpakaidetail extends Model
{

    protected $table = 'gudpakaidetail';

    public function good(){
        return $this->hasOne('App\Model\Barang', 'id', 'barang_id');
    }

    public function unit(){
        return $this->hasOne('App\Model\Brgsatuan', 'id', 'satuan_id');
    }

    public function gudpakai(){
        return $this->hasOne('App\Model\Gudpakai', 'id', 'gudpakai_id');
    }
    
    
}

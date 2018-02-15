<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Gudrevisi extends Model
{

    protected $table = 'gudrevisi';
    
    public function warehouse(){
        return $this->hasOne('App\Model\Gudang', 'id', 'gudang_id');
    }

    public function user(){
        return $this->hasOne('App\Model\User', 'id', 'users_id');
    }

    public function user_edit(){
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');
    }

    public function details(){
        return $this->hasMany('App\Model\Gudrevisidetail', 'gudrevisi_id', 'id');
    }

}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
	use SoftDeletes;
    protected $table = 'pembelian';
    protected $dates = ['deleted_at'];

    public function user() {
        return $this->hasOne('App\Model\User', 'id', 'users_id');   
    }

    public function user_edit() {
        return $this->hasOne('App\Model\User', 'id', 'users_id_edit');   
    }

    public function details()
    {
        return $this->hasMany('App\Model\PembelianDetail','pembelian_id','id');
    }

    public function purchase()
    {
        return $this->hasOne('App\Model\Gudminta', 'id', 'permintaan_id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Model\Supplier', 'id', 'supplier_id');
    }

    public function department()
    {
        return $this->hasOne('App\Model\Department', 'id', 'department_id');
    }
    
}

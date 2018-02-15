<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\PembelianDetail;
use App\Model\Pembelian;

class Gudmintastatus extends Model
{

    protected $table = 'gudmintastatus';

    public function user()
    {
        return $this->hasOne('\App\Model\User','id','users_id');
    }

    public function user_edit()
    {
        return $this->hasOne('\App\Model\User','id','users_id_edit');
    }

    public function po()
    {
        return $this->hasOne('App\Model\Gudminta','id','gudminta_id');
    }

}

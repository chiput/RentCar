<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\Gudterimadetail;

class PembelianStatus extends Model
{
	protected $table = 'pembelianstatus';

    public function order()
    {
        return $this->hasOne('App\Model\Pembelian','id','pembelian_id');
    }
}
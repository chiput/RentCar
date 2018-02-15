<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Model\Brgkategori;
use App\Model\Brgsatuan;
use App\Model\Account;
use App\Model\Gudang;

class Barang extends Model
{
		use SoftDeletes;

    protected $table = 'barang';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->hasOne(Brgkategori::class, 'id', 'brgkategori_id');
    }

    public function unit()
    {
        return $this->hasOne(Brgsatuan::class, 'id', 'brgsatuan_id');
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    public function hpp()
    {
        return $this->hasOne(Account::class, 'id', 'acchpp');
    }

    public function penjualan()
    {
        return $this->hasOne(Account::class, 'id', 'accpenjualan');
    }

    public function gudang()
    {
        return $this->hasOne(Gudang::class, 'id', 'gud1');
    }
}

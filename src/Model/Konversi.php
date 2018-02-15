<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Brgsatuan;

class Konversi extends Model
{
	use SoftDeletes;

    protected $table = 'konversi';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function satuan_1(){
        return $this->hasOne(Brgsatuan::class,'id','brgsatuan_id1');
    }

    public function satuan_2(){
        return $this->hasOne(Brgsatuan::class,'id','brgsatuan_id2');
    }
    
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brgkategori extends Model
{
	use SoftDeletes;

    protected $table = 'brgkategori';
    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function goods()
    {
        return $this->hasMany('App\Model\Barang','brgkategori_id','id');
    }
    
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Department;


class Gudang extends Model
{
	use SoftDeletes;

    protected $table = 'gudang';

    
    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function department(){
        return $this->hasOne(Department::class,'id','department_id');
    }

}

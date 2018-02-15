<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu_kategori extends Model
{
	use SoftDeletes;


    protected $table = 'menu_kategoris';


	public $timestamps = false;

    protected $dates = ['deleted_at'];
    
  

    
}

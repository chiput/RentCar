<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReskasirdetailwhitehouseMigration
{
    public function createTable ()
    {   
        //Capsule::schema()->dropIfExists('reskasirkudetail');
        if(!Capsule::schema()->hasTable('reskasirdetailwh'))
        {
            Capsule::schema()->create('reskasirdetailwh', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('reskasirwh_id');
                $table->string('menuid');
                $table->string('kuantitas');
                $table->string('harga');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

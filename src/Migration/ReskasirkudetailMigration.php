<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReskasirkudetailMigration
{
    public function createTable ()
    {   
        //Capsule::schema()->dropIfExists('reskasirkudetail');
        if(!Capsule::schema()->hasTable('reskasirkudetail'))
        {
            Capsule::schema()->create('reskasirkudetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('reskasirku_id');
                $table->string('menuid');
                $table->string('kuantitas');
                $table->string('harga');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class HotservicebarangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hotservicebarang'))
        {
            Capsule::schema()->create('hotservicebarang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('id2');
                $table->integer('kamarid');
                $table->double('kuantitas', 9, 2);
                $table->timestamps();
            });
        }
    }
}

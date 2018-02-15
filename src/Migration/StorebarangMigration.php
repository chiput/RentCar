<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class StorebarangMigration
{
    public function createTable ()
    {
        //Capsule::schema()->dropIfExists('reskasirku');
        if(!Capsule::schema()->hasTable('storebarang'))
        {
            Capsule::schema()->create('storebarang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('barang_id');
                $table->double('harga');
                $table->integer('users_id');
                $table->timestamps();
            });

        }
    }
}

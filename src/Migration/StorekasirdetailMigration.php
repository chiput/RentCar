<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class StorekasirdetailMigration
{
    public function createTable ()
    {   
        //Capsule::schema()->dropIfExists('reskasirkudetail');
        if(!Capsule::schema()->hasTable('storekasirdetails'))
        {
            Capsule::schema()->create('storekasirdetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('storekasir_id');
                $table->string('barang_id');
                $table->string('kuantitas');
                $table->string('harga');
                $table->softDeletes();
                $table->timestamps();
            });
        } else {
            Capsule::schema()->table('storekasirdetails', function($table)
            {
                if (Capsule::schema()->hasColumn('storekasirdetails', 'reskasirku_id')) {
                    $table->renameColumn('reskasirku_id', 'storekasir_id');
                } 
            });
        }

    }
}

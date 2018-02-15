<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class  ResmenudetailMigration
{
    public function createTable ()
    {    
        // Capsule::schema()->dropIfExists('resmenudetail');
        if(!Capsule::schema()->hasTable('resmenudetail'))
        {
            Capsule::schema()->create('resmenudetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('id2');
                $table->string('barangid');
                $table->string('satuanid');
                $table->string('gudangid');
                $table->string('kuantitas');
                $table->softDeletes();
                $table->timestamps();

            });
            Capsule::table('resmenudetail')->insert(
                [
                    ['id' => '1','id2' => '1','barangid' => '1','satuanid' => '1','gudangid' => '1','kuantitas' => '1','deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL],
                    ['id' => '2','id2' => '1','barangid' => '2','satuanid' => '1','gudangid' => '1','kuantitas' => '1','deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL],
                ]
                );
        }
    }
}

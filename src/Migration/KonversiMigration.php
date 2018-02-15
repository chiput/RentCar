<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class KonversiMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('konversi'))
        {
            Capsule::schema()->create('konversi', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('brgsatuan_id1');
                $table->integer('brgsatuan_id2');
                $table->double('nilai');
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });

            Capsule::table('konversi')->insert(
                array(
                    array('id' => '1','brgsatuan_id1' => '1','brgsatuan_id2' => '2','nilai' => '1000','users_id' => '1','deleted_at' => NULL,'created_at' => date('Y-m-d H:i:s'),'updated_at' => NULL),
                    array('id' => '2','brgsatuan_id1' => '2','brgsatuan_id2' => '1','nilai' => '0.001','users_id' => '1','deleted_at' => NULL,'created_at' => date('Y-m-d H:i:s'),'updated_at' => NULL)
                )
            );
        }
    }
}

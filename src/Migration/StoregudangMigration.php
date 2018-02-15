<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class StoregudangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('storegudang'))
        {
            Capsule::schema()->create('storegudang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudangid')->unique();
                $table->string('users_id');
                $table->timestamps();

            });
            // Capsule::table('resgudang')->insert(
            //     [
            // ['id' => '1','gudangid' => '3','users_id' => '1','created_at' => '2017-03-10 12:07:37','updated_at' => NULL],
            //     ]
            // );
        }
    }
}

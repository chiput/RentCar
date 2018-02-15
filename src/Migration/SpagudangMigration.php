<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SpagudangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('spagudang'))
        {
            Capsule::schema()->create('spagudang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudangid')->unique();
                $table->string('users_id');
                $table->timestamps();

            });
            // Capsule::table('spagudang')->insert(
            //     [
            // ['id' => '1','gudangid' => '3','users_id' => '1','created_at' => '2017-03-10 12:07:37','updated_at' => NULL],
            //     ]
            // );
        } 
    }
}

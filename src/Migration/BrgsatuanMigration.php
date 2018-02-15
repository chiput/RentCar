<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BrgsatuanMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('brgsatuan'))
        {
            Capsule::schema()->create('brgsatuan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });

            Capsule::table('brgsatuan')->insert(
                [
                    ['id'      => '1', 'nama'      => 'kilogram','users_id'     => '1', 'created_at'=>date("Y-m-d H:i:s")],
                    ['id'      => '2', 'nama'      => 'gram','users_id'     => '1','created_at'=>date("Y-m-d H:i:s")],
            ]
            );
        }
    }
}

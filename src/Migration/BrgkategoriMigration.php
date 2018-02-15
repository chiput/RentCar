<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BrgkategoriMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('brgkategori'))
        {
            Capsule::schema()->create('brgkategori', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });

            Capsule::table('brgkategori')->insert(
                [
                    ['id'      => '1', 'nama'      => 'makanan','users_id'     => '1', 'created_at'=>date("Y-m-d H:i:s")],
                ]
            );
        }
    }
}

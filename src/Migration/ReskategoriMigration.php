<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class  ReskategoriMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reskategori'))
        {
            Capsule::schema()->create('reskategori', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('nama');
                $table->string('users_id');
                $table->integer('is_active');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

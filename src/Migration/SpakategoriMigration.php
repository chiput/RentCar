<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class  SpakategoriMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('spakategori'))
        {
            Capsule::schema()->create('spakategori', function (Blueprint $table)
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

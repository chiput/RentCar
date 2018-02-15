<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class TelpBiayaMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('telpbiaya'))
        {
            Capsule::schema()->create('telpbiaya', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nodepan');
                $table->integer('durasi');
                $table->double('harga');
                $table->integer('stts');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

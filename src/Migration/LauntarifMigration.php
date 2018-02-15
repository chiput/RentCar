<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LauntarifMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('launtarif'))
        {
            Capsule::schema()->create('launtarif', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('kode');
                $table->string('nama');
                $table->integer('layananid');
                $table->double('nominal', 15, 2);
                $table->double('hargasupplier', 15, 2);
                $table->integer('aktif');
                $table->string('user');
                $table->timestamps();
            });
        }
    }
}

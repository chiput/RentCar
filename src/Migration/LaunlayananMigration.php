<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LaunlayananMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('launlayanan'))
        {
            Capsule::schema()->create('launlayanan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('nama');
                $table->string('aktif');
                $table->string('user');
                $table->timestamps();
            });
        }
    }
}

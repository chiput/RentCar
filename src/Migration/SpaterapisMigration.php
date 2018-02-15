<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SpaterapisMigration
{
    public function createTable ()
    {   
        if(!Capsule::schema()->hasTable('spaterapis'))
        {
            Capsule::schema()->create('spaterapis', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode')->unique();
                $table->string('nama');
                $table->string('alamat');
                $table->string('telepon');
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
        } 
    }
}

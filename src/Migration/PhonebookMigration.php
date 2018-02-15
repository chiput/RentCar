<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PhonebookMigration
{
    public function createTable ()
    {   
        ;
        if(!Capsule::schema()->hasTable('fronphonebook'))
        {
            Capsule::schema()->create('fronphonebook', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->string('keterangan');
                $table->string('telepon')->unique();
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}

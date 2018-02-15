<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RespesanandetailMigration
{
    public function createTable ()
    {   Capsule::schema()->dropIfExists('respesanandetail');
        if(!Capsule::schema()->hasTable('respesanandetail'))
        {
            Capsule::schema()->create('respesanandetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('id2');
                $table->string('menuid');
                $table->string('kuantitas');
                $table->string('harga');
                $table->string('tunggu',1);
                $table->string('batal',1);
                $table->string('masak',1);
                $table->string('saji');
                $table->timestamps();
            });
        }
    }
}

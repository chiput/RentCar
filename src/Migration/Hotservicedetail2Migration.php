<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Hotservicedetail2Migration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hotservicedetail2'))
        {
            Capsule::schema()->create('hotservicedetail2', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('id2');
                $table->integer('kamarid');
                $table->timestamps();
            });
        }
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomreldescriptionMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_rel_description'))
        {
            Capsule::schema()->create('room_rel_description', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('room_id');
                $table->integer('room_description_id');
            });
        }
    }
}

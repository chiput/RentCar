<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomDescriptionMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_descriptions'))
        {
            Capsule::schema()->create('room_descriptions', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('is_active');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

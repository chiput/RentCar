<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomFacilityMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_facilities'))
        {
            Capsule::schema()->create('room_facilities', function (Blueprint $table)
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

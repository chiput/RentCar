<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomrelfacilityMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_rel_facility'))
        {
            Capsule::schema()->create('room_rel_facility', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('room_id');
                $table->integer('room_facility_id');
                $table->timestamps();
            });
        }
    }
}

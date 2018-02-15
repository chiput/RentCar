<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomTypeMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_types'))
        {
            Capsule::schema()->create('room_types', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('is_active')->default(1)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

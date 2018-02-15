<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomPriceMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_rates'))
        {
            Capsule::schema()->create('room_rates', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('room_id');
                $table->integer('dayname_id');
                $table->integer('room_price');
                $table->integer('room_only_price');
                $table->integer('breakfast_price');
                $table->timestamps();
            });
        }
    }
}

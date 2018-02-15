<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomstatuslogMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_status_log'))
        {
            Capsule::schema()->create('room_status_log', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('date');
                $table->string('remark');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        } 
    }
}

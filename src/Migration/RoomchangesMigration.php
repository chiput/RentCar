<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomchangesMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_changes'))
        {
            Capsule::schema()->create('room_changes', function (Blueprint $table)
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

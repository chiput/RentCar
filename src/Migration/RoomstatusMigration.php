<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomstatusMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('room_status'))
        {
            Capsule::schema()->create('room_status', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('reservationdetail_id')->default(Capsule::raw('NULL'))->nullable();
                $table->integer('rooms_id');
                $table->date('date');
                $table->integer('status');
                $table->string('remark');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
        // echo Capsule::schema()->hasColumn('room_status', 'reservationdetail_id');
        if (!Capsule::schema()->hasColumn('room_status', 'reservationdetail_id')) {
            Capsule::schema()->table('room_status', function (Blueprint $table) {
                $table->integer('reservationdetail_id')->default(Capsule::raw('NULL'))->nullable();
            });
        }
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RoomMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('rooms'))
        {
            Capsule::schema()->create('rooms', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('number');
                $table->integer('adults');
                $table->integer('children');
                $table->string('buildings_id')->nullable();
                $table->string('level'); // us english
                $table->integer('room_type_id')->nullable();
                $table->integer('bed_type_id')->nullable();
                $table->string('currency');
                $table->text('note');
                $table->integer('is_active');
                $table->softDeletes();
                $table->timestamps();
            });
        }
        Capsule::schema()->table('rooms', function (Blueprint $table) {
            $table->integer('adults')->nullable()->change();
        }); 
        Capsule::schema()->table('rooms', function (Blueprint $table) {
            $table->integer('children')->nullable()->change();
        }); 
        Capsule::schema()->table('rooms', function (Blueprint $table) {
            $table->string('note')->change();
        });
        Capsule::schema()->table('rooms', function (Blueprint $table) {
            $table->text('note')->change();
        });
    }
}

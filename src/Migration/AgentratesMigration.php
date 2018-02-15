<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AgentratesMigration
{
    public function createTable ()
    {
        if(Capsule::schema()->hasTable('agent_rates')) Capsule::schema()->dropIfExists('agent_rates');
        
        Capsule::schema()->create('agent_rates', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('agents_id');
            $table->integer('room_id');
            $table->double('room_price')->default(0);
            $table->double('room_only_price')->default(0);
            $table->double('breakfast_price')->default(0);
            $table->integer('users_id')->default(1);
            $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();

            // $table->increments('id');
            // $table->integer('agents_id');
            // $table->integer('room_types_id');
            // $table->integer('bed_types_id');
            // $table->double('room_price');
            // $table->double('room_only_price');
            // $table->double('breakfast_price');
            // $table->integer('users_id');
            // $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
        });

        
    }
}

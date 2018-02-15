<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PeriodicratesMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('periodic_rates'))
        {
            Capsule::schema()->create('periodic_rates', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('room_types_id');
                $table->integer('bed_types_id');
                $table->string('remark');
                $table->double('markup');
                $table->integer('markup_percent')->nullable();
                $table->double('disc');
                $table->integer('disc_percent')->nullable();
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }
    }
}



<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BuildingsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('buildings'))
        {
            Capsule::schema()->create('buildings', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('desc');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }
    }
}

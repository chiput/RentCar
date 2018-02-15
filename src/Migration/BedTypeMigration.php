<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BedTypeMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('bed_types'))
        {
            Capsule::schema()->create('bed_types', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('is_active');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

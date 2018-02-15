<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CountryMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('countries'))
        {
            Capsule::schema()->create('countries', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('is_active')->default(1);
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

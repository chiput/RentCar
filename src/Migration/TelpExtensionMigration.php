<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class TelpExtensionMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('telpextension'))
        {
            Capsule::schema()->create('telpextension', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('extno');
                $table->integer('roomid');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

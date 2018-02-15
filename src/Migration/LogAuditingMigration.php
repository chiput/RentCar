<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LogAuditingMigration
{
    public function createTable ()
    {
        Capsule::schema()->dropIfExists('logauditing');
        if(!Capsule::schema()->hasTable('logauditing'))
        {
            Capsule::schema()->create('logauditing', function (Blueprint $table)
            {
                $table->increments('id');
                $table->dateTime('tanggal');
                $table->integer('id_table');
                $table->string('table');
                $table->string('field');
                $table->string('new');
                $table->string('old');
                $table->integer('users_id');
            });
        }
    }
}

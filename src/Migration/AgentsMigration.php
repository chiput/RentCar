<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AgentsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('agents'))
        {
            Capsule::schema()->create('agents', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->string('is_active')->default('1');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }
    }
}

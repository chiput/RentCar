<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AcckastypesMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('acckastypes'))
        {
            Capsule::schema()->create('acckastypes', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('accdebet_id')->default(0);
                $table->integer('acckredit_id')->default(0);
                $table->string('type')->default('');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });
            
        }
    }
}


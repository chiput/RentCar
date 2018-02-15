<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AddchargetypesMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('addchargetypes'))
        {
            Capsule::schema()->create('addchargetypes', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('accincome')->default(0);
                $table->integer('acccost')->default(0);
                $table->double('sell')->default(0);
                $table->double('buy')->default(0);
                $table->string('remark')->default('');
                $table->string('is_active')->default('1');
                $table->string('is_editable')->default('1');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();

            });

        }
    }
}

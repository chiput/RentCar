<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PeriodicratedetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('periodic_rate_details'))
        {
            Capsule::schema()->create('periodic_rate_details', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('periodic_rates_id');
                $table->integer('rooms_id');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }
    }
}

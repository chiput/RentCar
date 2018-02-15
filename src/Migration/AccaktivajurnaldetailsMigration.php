<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccaktivajurnaldetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accaktivajurnaldetails'))
        {
            Capsule::schema()->create('accaktivajurnaldetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('accaktivajurnals_id');
                $table->integer('accaktivas_id');
                $table->double('nominal');
                $table->integer('accjurnals_id');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });

        }
    }
}




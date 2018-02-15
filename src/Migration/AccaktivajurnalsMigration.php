<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccaktivajurnalsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accaktivajurnals'))
        {
            Capsule::schema()->create('accaktivajurnals', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });

        }
    }
}





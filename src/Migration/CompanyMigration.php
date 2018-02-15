<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CompanyMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('companies'))
        {
            Capsule::schema()->create('companies', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('discount');
                $table->integer('is_active')->default(1);
                $table->integer('users_id')->default(1);
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

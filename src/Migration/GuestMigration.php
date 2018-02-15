<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GuestMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('guests'))
        {
            Capsule::schema()->create('guests', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->text('address');
                $table->integer('country_id')->nullable();
                $table->string('idcode');
                $table->string('state');
                $table->string('city');
                $table->string('zipcode');
                $table->string('phone');
                $table->string('fax');
                $table->string('email');
                $table->string('company_id');
                $table->integer('sex');
                $table->date('date_of_birth');
                $table->date('date_of_validation');
                $table->integer('idtype_id')->nullable();
                $table->integer('is_active')->default(1);
                $table->integer('is_blacklist')->default(0);
                $table->integer('users_id')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        Capsule::schema()->table('guests', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->change();
            $table->date('date_of_validation')->nullable()->change();
            $table->string('company_id')->nullable()->change();
        });
    }
}

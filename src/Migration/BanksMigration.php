<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BanksMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('banks'))
        {
            Capsule::schema()->create('banks', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name')->default('');
                $table->string('accno')->default('');
                $table->string('code')->nullable();
                $table->string('accname')->default('');
                $table->integer('accounts_id')->default(0);
                $table->integer('accadmin')->default(0);
                $table->string('faktur2')->default('');
                $table->string('status')->default('AKTIF');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }
    }
}


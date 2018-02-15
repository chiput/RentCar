<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CurrencyrateMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('currency_rate'))
        {
            Capsule::schema()->create('currency_rate', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('currency_id');
                $table->date('date');
                $table->double('rate');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
    }
}
  
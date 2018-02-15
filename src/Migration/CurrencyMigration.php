<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CurrencyMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('currency'))
        {
            Capsule::schema()->create('currency', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->string('symbol');
                $table->integer('defa')->default('0');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

            $currency = array(
            array('id' => '1','code' => 'IDR','name' => 'Rupiah ','symbol' => 'Rp.','defa' => '0','users_id' => '1','created_at' => '2017-01-21 05:17:14','updated_at' => '2017-01-20 16:18:52','deleted_at' => NULL)
            );
            Capsule::table('currency')->insert($currency);

        }
    }
}

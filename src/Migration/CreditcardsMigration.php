<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CreditcardsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('creditcards'))
        {
            Capsule::schema()->create('creditcards', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('banks_id');
                $table->double('biaya');
                $table->string('jenis')->default('1');
                $table->integer('is_active')->default('1');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
    }
}

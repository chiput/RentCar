<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class DepositsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('deposits'))
        {
            Capsule::schema()->create('deposits', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('reservations_id')->default(0);
                $table->date('tanggal');
                $table->string('nobukti')->default('');
                $table->integer('accjurnals_id')->default(0);
                $table->double('nominal')->default(0);
                $table->string('type')->default('');
                $table->integer('status')->default(0);
                $table->integer('banks_id')->nullable();
                $table->integer('cards_id')->nullable();
                $table->string('creditcard')->default('');
                $table->date('creditcarddate')->nullable()->default(null);
                $table->string('keterangan')->default('');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        } 
    }
}

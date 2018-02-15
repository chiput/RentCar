<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReservationsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reservations'))
        {
            Capsule::schema()->create('reservations', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('accjurnals_id')->nullable();
                $table->timestamp('tanggal');
                $table->timestamp('checkin')->default(Capsule::raw('NULL'))->nullable();
                $table->timestamp('checkout')->default(Capsule::raw('NULL'))->nullable();
                $table->string('nobukti');
                $table->integer('contracts_id')->default(0);
                $table->integer('canmove')->default(0); //bisa pindah
                $table->integer('waitinglists_id')->default(0);
                $table->integer('kamar');
                $table->integer('adult')->default(0);
                $table->integer('child')->default(0);
                $table->integer('creditcard_id');
                $table->string('creditcard')->nullable();
                $table->date('creditcarddate')->nullable();
                $table->integer('guests_id')->nullable();
                $table->integer('agent_id')->nullable();
                $table->integer('marketings_id')->default(0)->nullable();
                $table->string('keterangan')->default('');
                $table->integer('status')->default(0); //'0 reservation, 1 waiting, 2 cancel',
                $table->date('canceldate')->nullable();
                $table->integer('accjurnal_cancel')->nullable();
                $table->string('remarks');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        }

        if(!Capsule::schema()->hasColumn('reservations','canmove')){
            Capsule::schema()->table('reservations', function (Blueprint $table) {
                $table->integer('canmove')->default(0); //bisa pindah
            });
        } elseif (!Capsule::schema()->hasColumn('reservations','users_id_edit')) {
           Capsule::schema()->table('reservations', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); 
            });
        } elseif (!Capsule::schema()->hasColumn('reservations','creditcard_id')) {
           Capsule::schema()->table('reservations', function (Blueprint $table) {
                $table->integer('creditcard_id')->after('users_id_edit'); 
            });
        }  

        Capsule::schema()->table('reservations', function (Blueprint $table) {
            $table->integer('creditcard_id')->nullable()->change();
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

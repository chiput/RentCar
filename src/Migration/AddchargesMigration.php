<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AddchargesMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('addcharges'))
        {
            Capsule::schema()->create('addcharges', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti')->nullable();
                $table->integer('reservationdetails_id')->default(0)->nullable();
                $table->integer('accjurnals_id')->default(0);
                $table->double('service')->default(0);
                $table->double('nservice')->default(0);
                $table->double('ppn')->default(0);
                $table->double('nppn')->default(0);
                $table->double('ntotal')->default(0);
                $table->string('remark')->default('');
                $table->string('pisah')->default('');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        } if (!Capsule::schema()->hasColumn('addcharges','users_id_edit')) {
            Capsule::schema()->table('addcharges', function(Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id');
            });
        }

        Capsule::schema()->table('addcharges', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}


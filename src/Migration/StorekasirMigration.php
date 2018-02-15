<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class StorekasirMigration
{
    public function createTable ()
    {
        //Capsule::schema()->dropIfExists('reskasirku');
        if(!Capsule::schema()->hasTable('storekasir'))
        {
            Capsule::schema()->create('storekasir', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal')->nullable();
                $table->string('nobukti')->nullable();
                $table->string('jurnalid')->nullable();
                $table->double('total',15,2);
                $table->integer('users_id');
                $table->integer('users_id_edit')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

        }
        if(!Capsule::Schema()->hasColumn('storekasir','diskon')) {
            Capsule::Schema()->table('storekasir', function($table)
            {
                $table->double('diskon')->after('total');
            });
        } elseif (!Capsule::Schema()->hasColumn('storekasir','users_id_edit')) {
            Capsule::Schema()->table('storekasir', function($table)
            {
                $table->integer('users_id_edit')->after('users_id');
            });
        }

        Capsule::schema()->table('storekasir', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

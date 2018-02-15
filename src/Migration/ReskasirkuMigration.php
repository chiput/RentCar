<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReskasirkuMigration
{
    public function createTable ()
    {
        //Capsule::schema()->dropIfExists('reskasirku');
        if(!Capsule::schema()->hasTable('reskasirku'))
        {
            Capsule::schema()->create('reskasirku', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal')->nullable();
                $table->string('nobukti')->nullable();
                $table->string('jurnalid')->nullable();
                $table->string('meja')->nullable();
                $table->double('pax');
                $table->string('waiters_id');
                $table->double('total',15,2);
                $table->double('bayar',15,2);
                $table->double('kembalian',15,2)->nullable();
                $table->double('tunai',15,2)->nullable();
                $table->string('kartubayar')->nullable();
                $table->string('nokartu')->nullable();
                $table->date('tglkartu')->nullable();
                $table->double('totalkamar',15,2)->nullable();
                $table->string('checkinid')->nullable();
                $table->integer('resto')->nullable();
                $table->string('cetak',1)->nullable();
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });

        }elseif(!Capsule::Schema()->hasColumn('reskasirku','users_id')) {
                Capsule::Schema()->table('reskasirku', function($table)
                {
                    $table->integer('users_id')->after('cetak');
                });
            }
        if(!Capsule::Schema()->hasColumn('reskasirku','resto')) {
            Capsule::Schema()->table('reskasirku', function($table)
            {
                $table->integer('resto')->nullable()->after('checkinid');
            });
        }
        if(!Capsule::Schema()->hasColumn('reskasirku','diskon')) {
            Capsule::Schema()->table('reskasirku', function($table)
            {
                $table->double('diskon')->after('total');
            });
        }
        if(!Capsule::Schema()->hasColumn('reskasirku','jenis_kartukredit')) {
            Capsule::Schema()->table('reskasirku', function($table)
            {
                $table->integer('jenis_kartukredit')->after('kartubayar');
            });
        }
        if(!Capsule::Schema()->hasColumn('reskasirku','addcharge_id')) {
            Capsule::Schema()->table('reskasirku', function($table)
            {
                $table->integer('addcharge_id')->after('jenis_kartukredit');
            });
        }
        if(Capsule::Schema()->hasColumn('reskasirku','nokartu') && Capsule::Schema()->hasColumn('reskasirku','tglkartu')) {
            Capsule::Schema()->table('reskasirku', function (Blueprint $table) {
                $table->dropColumn(['nokartu', 'tglkartu']);
            });
        }

        if(Capsule::Schema()->hasColumn('reskasirku','cetak')){
            Capsule::Schema()->table('reskasirku', function (Blueprint $table) {
                $table->dropColumn(['cetak']);
            });
        }
        if(!Capsule::Schema()->hasColumn('reskasirku','keterangan')){
            Capsule::Schema()->table('reskasirku', function (Blueprint $table) {
                $table->string('keterangan')->after('resto');
            });
        }

        Capsule::schema()->table('reskasirku', function (Blueprint $table) {
           $table->integer('kembalian')->nullable()->change();
           $table->integer('jenis_kartukredit')->nullable()->change();
           $table->integer('addcharge_id')->nullable()->change();
        }); 
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SpakasirMigration
{
    public function createTable ()
    {
        //Capsule::schema()->dropIfExists('reskasirku');
        if(!Capsule::schema()->hasTable('spakasir'))
        {
            Capsule::schema()->create('spakasir', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal')->nullable();
                $table->string('nobukti')->nullable();
                $table->string('jurnalid')->nullable();
                $table->string('namapelanggan');
                $table->double('pax');
                $table->string('terapis_id');
                $table->string('keterangan');
                $table->double('total',15,2);
                $table->double('bayar',15,2);
                $table->double('kembalian',15,2);
                $table->double('tunai',15,2)->nullable();
                $table->string('kartubayar')->nullable();
                $table->string('nokartu')->nullable();
                $table->date('tglkartu')->nullable();
                $table->double('totalkamar',15,2)->nullable();
                $table->string('checkinid')->nullable();
                $table->string('cetak',1)->nullable();
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });
        }

            if(!Capsule::Schema()->hasColumn('spakasir','users_id')) {
                Capsule::Schema()->table('spakasir', function($table)
                {
                    $table->integer('users_id')->after('cetak');
                });
            } 
            if(!Capsule::Schema()->hasColumn('spakasir','diskon')) {
                Capsule::Schema()->table('spakasir', function($table)
                {
                    $table->integer('diskon')->after('total');
                });
            } 
            if (!Capsule::Schema()->hasColumn('spakasir','users_id_edit')) {
                Capsule::Schema()->table('spakasir', function($table){
                    $table->integer('users_id_edit')->after('users_id');
                });
            } 
            if(Capsule::Schema()->hasColumn('spakasir','terapis_id')) {
                Capsule::Schema()->table('spakasir', function($table){
                    $table->dropColumn('terapis_id');
                });
            } 
            if(!Capsule::Schema()->hasColumn('spakasir','jenis_kartukredit')) {
                Capsule::Schema()->table('spakasir', function($table){
                    $table->integer('jenis_kartukredit')->after('kartubayar');
                });
            } 
            if(!Capsule::Schema()->hasColumn('spakasir','addcharge_id')) {
                Capsule::Schema()->table('spakasir', function($table)
                {
                    $table->integer('addcharge_id')->after('jenis_kartukredit');
                });
            }
            if(!Capsule::Schema()->hasColumn('spakasir','addcharge_id')) {
                Capsule::Schema()->table('spakasir', function($table)
                {
                    $table->integer('addcharge_id')->after('jenis_kartukredit');
                });
            }

            Capsule::schema()->table('spakasir', function (Blueprint $table) {
                $table->integer('users_id_edit')->nullable()->change();
                $table->integer('kembalian')->nullable()->change();
                $table->integer('jenis_kartukredit')->nullable()->change();
                $table->integer('addcharge_id')->nullable()->change();

                // if(Capsule::Schema()->hasColumn('spakasir','creditcard')) {
                //     $table->renameColumn('creditcard', 'jenis_kartukredit');
                // }
            }); 
    }
}

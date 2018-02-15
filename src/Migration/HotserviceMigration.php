<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class HotserviceMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hotservice'))
        {
            Capsule::schema()->create('hotservice', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->string('keterangan');
                $table->string('karyawanid');
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }
        if(Capsule::schema()->hasColumn('hotservice','user')){
            Capsule::schema()->table('hotservice', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('hotservice','users_id')){
            Capsule::schema()->table('hotservice', function (Blueprint $table) {
                $table->integer('users_id')->after('karyawanid'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('hotservice','users_id_edit')){
            Capsule::schema()->table('hotservice', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        Capsule::schema()->table('hotservice', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

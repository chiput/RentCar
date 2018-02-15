<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class HottemuanMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hottemuan'))
        {
            Capsule::schema()->create('hottemuan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->string('barangid');
                $table->string('karyawanid');
                $table->string('checkinid');
                $table->string('keterangan');
                $table->string('aktif');
                //$table->string('user');
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }
        
        if(Capsule::schema()->hasColumn('hottemuan','user')){
            Capsule::schema()->table('hottemuan', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('hottemuan','users_id')){
            Capsule::schema()->table('hottemuan', function (Blueprint $table) {
                $table->integer('users_id')->after('aktif'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('hottemuan','users_id_edit')){
            Capsule::schema()->table('hottemuan', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        Capsule::schema()->table('hottemuan', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

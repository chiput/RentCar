<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class HothilangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hothilang'))
        {
            Capsule::schema()->create('hothilang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->string('barangid');
                $table->string('checkinid');
                $table->string('keterangan');
                $table->string('aktif');
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        if(Capsule::schema()->hasColumn('hothilang','user')){
            Capsule::schema()->table('hothilang', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('hothilang','users_id')){
            Capsule::schema()->table('hothilang', function (Blueprint $table) {
                $table->integer('users_id')->after('aktif'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('hothilang','users_id_edit')){
            Capsule::schema()->table('hothilang', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        Capsule::schema()->table('hothilang', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

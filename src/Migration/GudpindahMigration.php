<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudpindahMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudpindah'))
        {
            Capsule::schema()->create('gudpindah', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('gudang_id1');
                $table->integer('gudang_id2');
                $table->string('keterangan');
                $table->integer('cetak')->nullable();
                $table->integer('users_id_edit');
                $table->integer('users_id');
                $table->timestamps();
            });
        }
        if(Capsule::schema()->hasColumn('gudpindah','user')){
            Capsule::schema()->table('gudpindah', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('gudpindah','users_id')){
            Capsule::schema()->table('gudpindah', function (Blueprint $table) {
                $table->integer('users_id')->after('aktif'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('gudpindah','users_id_edit')){
            Capsule::schema()->table('gudpindah', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        Capsule::schema()->table('gudpindah', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BorrowMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hotpinjam'))
        {
            Capsule::schema()->create('hotpinjam', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->date('tanggalkembali')->nullable();
                $table->string('nobukti');
                $table->string('barangid');
                $table->string('checkinid');
                $table->double('kuantitas', 9, 2);
                $table->double('kuantitaskembali', 9, 2)->nullable();
                $table->string('keterangan');
                //$table->string('user');
                $table->char('aktif', 1);
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }
        
        if(Capsule::schema()->hasColumn('hotpinjam','user')){
            Capsule::schema()->table('hotpinjam', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('hotpinjam','users_id')){
            Capsule::schema()->table('hotpinjam', function (Blueprint $table) {
                $table->integer('users_id')->after('aktif'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('hotpinjam','users_id_edit')){
            Capsule::schema()->table('hotpinjam', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        Capsule::schema()->table('hotpinjam', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

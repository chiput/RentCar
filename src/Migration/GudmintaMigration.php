<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudmintaMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudminta'))
        {
            Capsule::schema()->create('gudminta', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('department_id');
                $table->string('keterangan');
                $table->integer('cetak')->nullable();
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }
        if(Capsule::schema()->hasColumn('gudminta','user')){
            Capsule::schema()->table('gudminta', function (Blueprint $table) {
                $table->dropColumn('user');
            });
        }

        if(!Capsule::schema()->hasColumn('gudminta','users_id')){
            Capsule::schema()->table('gudminta', function (Blueprint $table) {
                $table->integer('users_id')->after('aktif'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('gudminta','users_id_edit')){
            Capsule::schema()->table('gudminta', function (Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id'); //bisa pindah
            });
        }

        if(!Capsule::schema()->hasColumn('gudminta','status')){
            Capsule::schema()->table('gudminta', function (Blueprint $table) {
                $table->integer('status')->after('cetak')->default(0); //status
            });
        }

        if(!Capsule::schema()->hasColumn('gudminta','pemakstatus')){
            Capsule::schema()->table('gudminta', function (Blueprint $table) {
                $table->integer('pemakstatus')->after('status')->default(0); //status
            });
        }

        Capsule::schema()->table('gudminta', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

/*
CREATE TABLE `gudminta` (
  `id` varchar(30) NOT NULL DEFAULT '',
  `tanggal` date NOT NULL DEFAULT '0000-00-00',
  `nobukti` varchar(30) NOT NULL DEFAULT '',
  `departemenid` varchar(30) NOT NULL DEFAULT '',
  `keterangan` varchar(300) NOT NULL DEFAULT '',
  `cetak` char(1) NOT NULL DEFAULT '',
  `useredit` varchar(30) NOT NULL DEFAULT '',
  `jamedit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user` varchar(30) NOT NULL DEFAULT '',
  `jam` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*/
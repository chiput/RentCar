<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudhilangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudhilang'))
        {
            Capsule::schema()->create('gudhilang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('gudang_id');
                $table->integer('accjurnal_id')->nullable();
                $table->string('keterangan');
                $table->integer('cetak')->default(0);
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        Capsule::schema()->table('gudhilang', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

// CREATE TABLE `gudhilang` (
//   `id` varchar(30) NOT NULL DEFAULT '',
//   `tanggal` date NOT NULL DEFAULT '0000-00-00',
//   `nobukti` varchar(30) NOT NULL DEFAULT '',
//   `gudangid` varchar(30) NOT NULL DEFAULT '',
//   `jurnalid` varchar(30) NOT NULL DEFAULT '',
//   `keterangan` varchar(300) NOT NULL DEFAULT '',
//   `cetak` char(1) NOT NULL DEFAULT '',
//   `useredit` varchar(30) NOT NULL DEFAULT '',
//   `jamedit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
//   `user` varchar(30) NOT NULL DEFAULT '',
//   `jam` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

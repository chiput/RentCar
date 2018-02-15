<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudopnameMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudopname'))
        {
            Capsule::schema()->create('gudopname', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('gudang_id');
                $table->integer('accjurnal_id')->nullable();
                $table->string('keterangan');
                $table->string('cetak')->nullable();
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        Capsule::schema()->table('gudopname', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

// CREATE TABLE `gudopname` (
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

// --
// -- Dumping data for table `gudopname`
// --

// INSERT INTO `gudopname` (`id`, `tanggal`, `nobukti`, `gudangid`, `jurnalid`, `keterangan`, `cetak`, `useredit`, `jamedit`, `user`, `jam`) VALUES
// ('ADMN20160510-113738', '2016-05-10', 'SO.16050001', '20121230-085045', 'ADMN20160510-113738', '', '0', 'admin', '2016-05-10 11:37:39', 'admin', '2016-05-10 11:37:39');
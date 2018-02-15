<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudhilangdetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudhilangdetail'))
        {
            Capsule::schema()->create('gudhilangdetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudhilang_id');
                $table->integer('barang_id');
                $table->integer('satuan_id');
                $table->double('kuantitas');
                $table->timestamps();
            });
        }
    }
}

// CREATE TABLE `gudhilangdetail` (
//   `id` varchar(30) NOT NULL DEFAULT '',
//   `id2` varchar(10) NOT NULL DEFAULT '',
//   `barangid` varchar(30) NOT NULL DEFAULT '',
//   `satuanid` varchar(30) NOT NULL DEFAULT '',
//   `kuantitas` double(9,2) NOT NULL DEFAULT '0.00'
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

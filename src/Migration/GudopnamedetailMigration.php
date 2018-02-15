<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudopnamedetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudopnamedetail'))
        {
            Capsule::schema()->create('gudopnamedetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudopname_id');
                $table->integer('barang_id');
                $table->integer('satuan_id');
                $table->double('kuantitas');
                $table->integer('users_id');
                $table->timestamps();
            });
        }
    }
}


// CREATE TABLE `gudopnamedetail` (
//   `id` varchar(30) NOT NULL DEFAULT '',
//   `id2` varchar(10) NOT NULL DEFAULT '',
//   `barangid` varchar(30) NOT NULL DEFAULT '',
//   `satuanid` varchar(30) NOT NULL DEFAULT '',
//   `kuantitas` double(15,2) NOT NULL DEFAULT '0.00'
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

// --
// -- Dumping data for table `gudopnamedetail`
// --

// INSERT INTO `gudopnamedetail` (`id`, `id2`, `barangid`, `satuanid`, `kuantitas`) VALUES
// ('ADMN20160510-113738', '1', '1', '20121230-123723', 1000.00),
// ('ADMN20160510-113738', '2', 'ADMN20160509-145151', '20121230-123723', 1000.00);

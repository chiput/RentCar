<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudrevisidetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudrevisidetail'))
        {
            Capsule::schema()->create('gudrevisidetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudrevisi_id');
                $table->integer('barang_id');
                $table->integer('satuan_id');
                $table->double('kuantitas');
                $table->double('harga');
                $table->timestamps();
            });
        }
    }
}

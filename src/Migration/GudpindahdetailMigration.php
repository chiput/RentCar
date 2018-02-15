<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudpindahdetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudpindahdetail'))
        {
            Capsule::schema()->create('gudpindahdetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudpindah_id');
                $table->integer('barang_id');
                $table->integer('brgsatuan_id');
                $table->double('kuantitas');
                $table->timestamps();
            });
        }
    }
}

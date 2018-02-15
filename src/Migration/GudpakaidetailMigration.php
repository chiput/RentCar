<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudpakaidetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudpakaidetail'))
        {
            Capsule::schema()->create('gudpakaidetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudpakai_id');
                $table->integer('barang_id');
                $table->integer('satuan_id');
                $table->integer('account_id');
                $table->double('kuantitas');
                $table->timestamps();
            });
        }
    }
}

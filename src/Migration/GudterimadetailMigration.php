<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudterimadetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudterimadetail'))
        {
            Capsule::schema()->create('gudterimadetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('gudterima_id');
                $table->integer('barang_id');
                $table->integer('satuan_id');
                $table->date('tglexpired')->nullable();
                $table->double('kuantitas')->nullable();
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
    }
}



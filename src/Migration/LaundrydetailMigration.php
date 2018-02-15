<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LaundrydetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('laundrydetail'))
        {
            Capsule::schema()->create('laundrydetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('id2');
                $table->integer('tarifid');
                $table->string('keterangan');
                $table->double('kuantitas', 9, 0);
                $table->double('harga', 15, 2);
                $table->double('diskon', 15, 2);
                $table->timestamps();
            });
        }
    }
}

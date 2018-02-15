<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class TelpBillingMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('telpbilling'))
        {
            Capsule::schema()->create('telpbilling', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('roomid');
                $table->integer('biaya');
                $table->date('tanggal')->nullable();
                $table->string('jam');
                $table->string('notelp');
                $table->string('durasi');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

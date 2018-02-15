<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LaundrykasirMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('launkasir'))
        {
            Capsule::schema()->create('launkasir', function (Blueprint $table)
            {
                $table->integer('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->double('diskon', 15, 2)->nullable();
                $table->double('service', 15, 2)->nullable();
                $table->double('bayar', 15, 2)->nullable();
                $table->double('kembalian', 15, 2)->nullable();
                $table->string('checkinid');
                $table->timestamps();
            });
        }
    }
}

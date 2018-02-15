<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class LaundryMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('laundry'))
        {
            Capsule::schema()->create('laundry', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->string('checkinid');
                $table->integer('supplierid');
                $table->string('keterangan');
                $table->integer('proses');
                $table->timestamps();
            });
        }
    }
}

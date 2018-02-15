<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReskasirwhitehouseMigration
{
    public function createTable ()
    {
        //Capsule::schema()->dropIfExists('reskasirku');
        if(!Capsule::schema()->hasTable('reskasirwh'))
        {
            Capsule::schema()->create('reskasirwh', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal')->nullable();
                $table->string('nobukti')->nullable();
                $table->string('jurnalid')->nullable();
                $table->string('meja')->nullable();
                $table->double('pax');
                $table->string('waiters_id');
                $table->double('total',15,2);
                $table->double('bayar',15,2);
                $table->double('kembalian',15,2);
                $table->double('tunai',15,2)->nullable();
                $table->string('kartubayar')->nullable();
                $table->string('nokartu')->nullable();
                $table->date('tglkartu')->nullable();
                $table->double('totalkamar',15,2);
                $table->string('checkinid')->nullable();
                $table->string('cetak',1)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

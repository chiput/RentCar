<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class   ReskasirMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reskasir'))
        {
            Capsule::schema()->create('reskasir', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal')->nullable();
                $table->string('nobukti')->nullable();
                $table->string('satuanid')->nullable();
                $table->string('pelangganid')->nullable();
                $table->string('jurnalid')->nullable();
                $table->string('mejaid2')->nullable();
                $table->string('pisah',1);
                $table->string('diskonpersen');
                $table->double('diskon',15,2);
                $table->double('service',9,2);
                $table->double('nservice',15,2);
                $table->double('ppn',9,2);
                $table->double('nppn',15,2);
                $table->double('bayar',15,2);
                $table->double('kembalian',15,2);
                $table->string('tunai',1)->nullable();
                $table->string('tempo')->nullable();
                $table->double('bankid',15,2)->nullable();
                $table->string('kartuid')->nullable();
                $table->string('nokartu')->nullable();
                $table->date('tglkartu')->nullable();
                $table->string('checkinid')->nullable();
                $table->string('keterangan')->nullable();
                $table->string('cetak',1)->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

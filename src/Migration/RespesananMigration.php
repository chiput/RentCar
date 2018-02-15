<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RespesananMigration
{
    public function createTable ()
    {    Capsule::schema()->dropIfExists('respesanan');
        if(!Capsule::schema()->hasTable('respesanan'))
        {
            Capsule::schema()->create('respesanan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->string('pelangganid');
                $table->string('mejaid');
                $table->string('jenispelanggan',1);
                $table->string('keterangan');
                $table->string('proses',1);
                $table->string('cetak',1);
                $table->string('users_id');
                $table->timestamps();
            });


        }
    }
}

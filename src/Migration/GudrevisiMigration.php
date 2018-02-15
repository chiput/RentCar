<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudrevisiMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudrevisi'))
        {
            Capsule::schema()->create('gudrevisi', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('gudang_id');
                $table->integer('accjurnal_id')->nullable();
                $table->string('keterangan');
                $table->string('cetak')->nullable();
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        Capsule::schema()->table('gudrevisi', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

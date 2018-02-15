<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudpakaiMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudpakai'))
        {
            Capsule::schema()->create('gudpakai', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti');
                $table->integer('gudang_id');
                $table->integer('accjurnal_id')->nullable();
                $table->string('keterangan');
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        Capsule::schema()->table('gudpakai', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

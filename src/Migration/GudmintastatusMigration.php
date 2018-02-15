<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudmintastatusMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudmintastatus'))
        {
            Capsule::schema()->create('gudmintastatus', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->integer('gudminta_id');
                $table->string('keterangan');
                $table->integer('status')->nullable();
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
            });
        }

        Capsule::schema()->table('gudmintastatus', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}


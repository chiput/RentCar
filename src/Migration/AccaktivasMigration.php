<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccaktivasMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accaktivas'))
        {
            Capsule::schema()->create('accaktivas', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('accjurnals_id');
                $table->date('tanggal');
                $table->string('nama');
                $table->double('harga');
                $table->double('residu');
                $table->double('umur');
                $table->integer('accaktivagroups_id');
                $table->integer('accaktiva_id');
                $table->integer('acckas_id');
                $table->integer('accakumulasi_id');
                $table->integer('accpenyusutan_id');
                $table->string('metode')->default("GARIS LURUS");
                $table->string('kondisi')->default("BAIK");
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });

        }
    }
}

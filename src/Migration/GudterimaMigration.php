<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudterimaMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudterima'))
        {
            Capsule::schema()->create('gudterima', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti')->nullable();
                $table->integer('pembelian_id');
                $table->integer('gudang_id');
                $table->integer('accjurnals_id')->nullable();
                $table->string('keterangan')->nullable();
                $table->integer('cetak')->nullable();
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }

        Capsule::schema()->table('gudterima', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}



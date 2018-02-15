<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SpalayananMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('spalayanan'))
        {
            Capsule::schema()->create('spalayanan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('nama_layanan');
                $table->string('kategoriid');
                $table->string('accountid');
                $table->mediumText('keterangan');
                $table->double('biayalain',15,2);
                $table->double('hargajual',15,2);
                $table->double('diskon',15,2);
                $table->char('aktif',1)->default('1');
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
            // Capsule::table('spalayanan')->insert(
            //     [
            //         ['id' => '1','kode' => 'S-01','nama_layanan' => 'Pijat Urut','kategoriid' => '1','accountid' => '1','keterangan' => 'Di Goreng','biayalain' => '0.00','hargajual' => '20000.00','aktif' => '1','users_id' => '1','created_at' => '2017-03-10 13:29:05','updated_at' => '2017-03-10 13:29:05','deleted_at' => NULL],
            //     ]
            // );
        } 
        if(!Capsule::schema()->hasColumn('spalayanan','diskon')){
            Capsule::schema()->table('spalayanan', function (Blueprint $table) {
                $table->double('diskon',15,2)->after('hargajual'); //bisa pindah
            });
        }
    }
}

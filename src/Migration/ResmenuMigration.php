<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ResmenuMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('resmenu'))
        {
            Capsule::schema()->create('resmenu', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('nama');
                $table->string('kategoriid');
                $table->string('accountid');
                $table->mediumText('keterangan');
                $table->double('biayalain',15,2);
                $table->double('hargajual',15,2);
                $table->char('aktif',1)->default('1');
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
            Capsule::table('resmenu')->insert(
                [
                    ['id' => '1','kode' => 'M-01','nama' => 'Pisang Goreng','kategoriid' => '1','accountid' => '1','keterangan' => 'Di Goreng','biayalain' => '0.00','hargajual' => '20000.00','aktif' => '1','users_id' => '1','created_at' => '2017-03-10 13:29:05','updated_at' => '2017-03-10 13:29:05','deleted_at' => NULL],
                ]
            );
        }
    }
}

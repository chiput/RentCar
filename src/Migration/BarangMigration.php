<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BarangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('barang'))
        {
            Capsule::schema()->create('barang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('nama');
                $table->integer('brgsatuan_id');
                $table->integer('brgkategori_id');
                $table->integer('account_id');
                $table->integer('accpenjualan');
                $table->integer('acchpp');
                $table->double('hargajual');
                $table->double('hargastok');
                $table->double('minimal');
                $table->integer('expired');
                $table->integer('inventaris');
                $table->integer('users_id');
                $table->softDeletes();
                $table->timestamps();
            });
            Capsule::table('barang')->insert(
                [
                    ['id' => '1','kode' => '101','nama' => 'Pisang','brgsatuan_id' => '1','brgkategori_id' => '1','account_id' => '1','accpenjualan' => '1','acchpp' => '1','hargajual' => '5000','hargastok' => '2500','minimal' => '10','expired' => '0','inventaris' => '0','users_id' => '1','deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL],
                    ['id' => '2','kode' => '102','nama' => 'Tepung','brgsatuan_id' => '1','brgkategori_id' => '1','account_id' => '1','accpenjualan' => '1','acchpp' => '1','hargajual' => '5000','hargastok' => '2500','minimal' => '50','expired' => '0','inventaris' => '0','users_id' => '1','deleted_at' => NULL,'created_at' => NULL,'updated_at' => NULL],
                ]
            );
        }
    }
}

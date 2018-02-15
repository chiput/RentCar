<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class RespelangganMigration
{
    public function createTable ()
    {   
        // Capsule::schema()->dropIfExists('respelanggan');
        if(!Capsule::schema()->hasTable('respelanggan'))
        {
            Capsule::schema()->create('respelanggan', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode')->unique();
                $table->string('nama');
                $table->string('contact');
                $table->string('alamat');
                $table->string('kotaid');
                $table->string('telepon');
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            }); 
        }
        if(Capsule::schema()->hasColumn('respelanggan','kode')) {
            Capsule::schema()->table('respelanggan', function($table)
            {
                $table->renameColumn('kode','kode_pelanggan');
            });
        }
        if(Capsule::schema()->hasColumn('respelanggan','contact')) {
            Capsule::schema()->table('respelanggan',function($table)
            {
                $table->dropColumn('contact');
            });
        }
        if(Capsule::schema()->hasColumn('respelanggan','alamat')) {
            Capsule::schema()->table('respelanggan',function($table)
            {
                $table->dropColumn('alamat');
            });
        }
        if(Capsule::schema()->hasColumn('respelanggan','kotaid')) {
            Capsule::schema()->table('respelanggan',function($table)
            {
                $table->dropColumn('kotaid');
            });
        }
    }
}

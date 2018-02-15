<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReswaiterMigration
{
    public function createTable ()
    {   
        
        if(!Capsule::schema()->hasTable('reswaiter'))
        {
            Capsule::schema()->create('reswaiter', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode')->unique();
                $table->string('nama');
                $table->string('alamat');
                $table->string('telepon');
                $table->string('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
            Capsule::table('reswaiter')->insert(
                [
                    ['id' => '1','kode' => 'W-001','nama' => 'Supri','alamat' => 'seplindit','telepon' => '08123958246','users_id' => '1','created_at' => '2017-03-10 11:50:55','updated_at' => '2017-03-10 11:50:55','deleted_at' => NULL],
                ]
                );
        }
    }
}

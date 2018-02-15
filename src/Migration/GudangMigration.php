<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class GudangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('gudang'))
        {
            Capsule::schema()->create('gudang', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->integer('department_id');
                $table->integer('users_id');
                $table->timestamps();
                $table->softDeletes();
            });

            $this->seed();
        }
    }

    public function seed ()
    {
        if(Capsule::schema()->hasTable('gudang'))
        {
            Capsule::table('gudang')->insert(
            [ 'nama' => 'Cleaning','department_id' => '1','users_id' => '1']
            );
             Capsule::table('gudang')->insert(
            [ 'nama' => 'Teknisi','department_id' => '2','users_id' => '1']
            );
              Capsule::table('gudang')->insert(
                [ 'nama' => 'Resto','department_id' => '3','users_id' => '1']
            );
        }
    }
}

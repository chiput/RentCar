<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class IdTypeMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('idtypes'))
        {
            Capsule::schema()->create('idtypes', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('is_active')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
            
            Capsule::table('idtypes')->insert(
                [
                    ['id'      => '3', 'name'      => 'KTP','is_active'     => '1', 'created_at'=>date("Y-m-d H:i:s")],
                    ['id'      => '4', 'name'      => 'SIM','is_active'     => '1','created_at'=>date("Y-m-d H:i:s")],
                    ['id'      => '5', 'name'      => 'PASPOR','is_active'     => '1','created_at'=>date("Y-m-d H:i:s")],
                    ['id'      => '6', 'name'      => 'VISA','is_active'     => '1','created_at'=>date("Y-m-d H:i:s")],
            ]
            );

        }
    }
}

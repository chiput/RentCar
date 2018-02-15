<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class  ReskasirdetailMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reskasirdetail'))
        {
            Capsule::schema()->create('reskasirdetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('id2');
                $table->string('pesananid');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }
}

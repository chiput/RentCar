<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SpakasirdetailMigration
{
    public function createTable ()
    {   
        //Capsule::schema()->dropIfExists('reskasirkudetail');
        if(!Capsule::schema()->hasTable('spakasirdetail'))
        {
            Capsule::schema()->create('spakasirdetail', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('spakasir_id');
                $table->string('layananid');
                $table->string('kuantitas');
                $table->string('harga');
                $table->integer('terapisid');
                $table->softDeletes();
                $table->timestamps();
            });
        }
        
        if(!Capsule::Schema()->hasColumn('spakasirdetail','terapisid')) {
            Capsule::Schema()->table('spakasirdetail', function($table)
            {
                $table->integer('terapisid')->nullable()->after('harga');
            });
        } 
    }
}

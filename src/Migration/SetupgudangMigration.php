<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SetupgudangMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('setupgudangs'))
        {
            Capsule::schema()->create('setupgudangs', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('value');
                $table->timestamps();
            });

            $this->seed();
        }
    }
    public function seed()
    {
        // kulkul_hos.options
        $options = array(
                      array('name' => 'gud_store','value' => ''),
                      array('name' => 'gud_restorente','value' => ''),
                      array('name' => 'gud_whitehorse','value' => ''),
                      array('name' => 'menu_resto','value' => ''),
                      );
                    
        Capsule::table('setupgudangs')->insert($options);
    }
}

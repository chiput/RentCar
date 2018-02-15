<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccgroupsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accgroups'))
        {
            Capsule::schema()->create('accgroups', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
            });

            $accgroups = array(
                array('id' => '1','name' => 'AKTIVA LANCAR'),
                array('id' => '2','name' => 'AKTIVA TETAP'),
                array('id' => '3','name' => 'AKTIVA LAIN'),
                array('id' => '4','name' => 'HUTANG LANCAR'),
                array('id' => '5','name' => 'HUTANG JANGKA PANJANG'),
                array('id' => '6','name' => 'MODAL'),
                array('id' => '7','name' => 'PENDAPATAN'),
                array('id' => '8','name' => 'HPP'),
                array('id' => '9','name' => 'BIAYA')
            );
            
            Capsule::table("accgroups")->insert($accgroups);

            
        }
    }
}

<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class Menukatagori
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reskategori'))
        {
            Capsule::schema()->create('reskategori', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode')->unique();
                $table->string('nama');
                $table->string('users_id');
                $table->integer('is_active')->default(1);
                $table->softDeletes();
                $table->timestamps();
            });

            $this->insertTable();
        }

    }

     public function deleteTable ()
    {
        if(!Capsule::schema()->hasTable('reskategori'))
        {
           Schema::dropIfExists('reskategori');
        }
        
    }

     public function insertTable ()
    {
        if(Capsule::schema()->hasTable('reskategori'))
        {
            Capsule::table('reskategori')->insert(
            ['kode' => 'K-1', 'nama' => 'Food','users_id' => 'Food',]
            );
        }   
    }
     public function updateTable ()
    {
        if(Capsule::schema()->hasTable('reskategori'))
        {
           Capsule::table('reskategori', function (Blueprint $table) 
            {
                $table->string('nama',20)->change();
              
            });
        }   
    }

    
}

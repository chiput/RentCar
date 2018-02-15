<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ResourceCategoryMigration
{
    public function createTable ()
    {
        Capsule::schema()->dropIfExists('resource_categories');
        if(!Capsule::schema()->hasTable('resource_categories'))
        {
            Capsule::schema()->create('resource_categories', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->integer('sequence');
                $table->timestamps();
            });

            // `kulkul_hos`.`resource_categories`
            $resource_categories = array(
                                array('id' => '1','name' => 'accounting','sequence' => '1','created_at' => '2016-10-17 04:00:00','updated_at' => NULL),
                                array('id' => '2','name' => 'setup','sequence' => '2','created_at' => '2016-10-17 04:00:00','updated_at' => NULL),
                                array('id' => '3','name' => 'frontdesk','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '4','name' => 'housekeeping','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '5','name' => 'restaurant','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '6','name' => 'pembelian','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '7','name' => 'logistic','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '8','name' => 'spa','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '9','name' => 'management','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL),
                                array('id' => '10','name' => 'store','sequence' => '0','created_at' => '2016-10-18 04:00:00','updated_at' => NULL)
                                );

            Capsule::table('resource_categories')->insert($resource_categories);
        }
    }
}

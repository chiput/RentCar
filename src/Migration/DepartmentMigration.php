<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class DepartmentMigration
{
    public function createTable ()
    {
        Capsule::schema()->dropIfExists('departments');
        if(!Capsule::schema()->hasTable('departments'))
        {
            Capsule::schema()->create('departments', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->string('users_id');
                $table->integer('is_active');
                $table->timestamps();
                $table->softDeletes();
            });
            $this->seed();
        }

        if(!Capsule::Schema()->hasColumn('departments','ket')) {
            Capsule::Schema()->table('departments', function($table)
            {
                $table->string('ket')->after('is_active');
            });
        }
    
    }

    public function seed()
    {
        // Dapartement
        $dapartements = array(
                array('id' => '1','code' => 'D-01','name' => 'Accounting','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '2','code' => 'D-02','name' => 'Front Office','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '3','code' => 'D-03','name' => 'Housekeeping','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '4','code' => 'D-04','name' => 'Logistik','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '5','code' => 'D-05','name' => 'Pembelian','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '6','code' => 'D-06','name' => 'Restoran','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '7','code' => 'D-07','name' => 'Spa','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '8','code' => 'D-08','name' => 'Store','users_id' => '1','is_active' => '1', 'created_at' => '2017-07-31 11:44:23','updated_at' => NULL,'deleted_at' => NULL),
            );
         Capsule::table('departments')->insert($dapartements);

    }

}

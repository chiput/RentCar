<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccaktivagroupMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accaktivagroups'))
        {
            Capsule::schema()->create('accaktivagroups', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('nama');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

            $accaktivagroups = array(
                                array('id' => '1','nama' => 'AC','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '2','nama' => 'Alat Kantor','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '3','nama' => 'Kendaraan','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '4','nama' => 'Komputer','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '5','nama' => 'Lain-lain','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '6','nama' => 'Lemari','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '7','nama' => 'Meja Kursi','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '8','nama' => 'Telepon','users_id' => '0','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '10','nama' => 'Surat Berharga ','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '11','nama' => 'Gedung ','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '12','nama' => 'Barang','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '14','nama' => 'Kulkas','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '15','nama' => 'Oven','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '17','nama' => 'AKTIVA MACET','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL),
                                array('id' => '18','nama' => 'Tanah','users_id' => '1','created_at' => '2017-02-18 15:21:25','updated_at' => '2017-02-18 15:21:25','deleted_at' => NULL)
                                );

            Capsule::table("accaktivagroups")->insert($accaktivagroups);
        }
    }
}




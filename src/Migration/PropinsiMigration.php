<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PropinsiMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('propinsi'))
        {
            Capsule::schema()->create('propinsi', function (Blueprint $table)
            {

                $table->increments('id');
                $table->string('nama');
                $table->integer('user');
                $table->dateTime('created_at');
                
                //$table->primary('id');

            });

            $this->seed();
        }
    }

    public function seed()
    {
        // Negara
        // `kulkul_hos`.`propinsi`
        $propinsi = array(
            array('id' => '1','nama' => 'JAWA BARAT','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '10','nama' => 'SUMATERA UTARA','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '11','nama' => 'SUMATERA BARAT','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '12','nama' => 'RIAU','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '13','nama' => 'SUMATERA SELATAN','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '14','nama' => 'KEPULAUAN BANGKA BELITUNG','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '15','nama' => 'LAMPUNG','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '16','nama' => 'KALIMANTAN SELATAN','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '17','nama' => 'KALIMANTAN BARAT','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '18','nama' => 'KALIMANTAN TIMUR','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '19','nama' => 'KALIMANTAN TENGAH','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '2','nama' => 'BANTEN','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '20','nama' => 'SULAWESI TENGAH','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '21','nama' => 'SULAWESI SELATAN','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '22','nama' => 'SULAWESI UTARA','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '23','nama' => 'GORONTALO','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '24','nama' => 'SULAWESI TENGGARA','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '25','nama' => 'NUSA TENGGARA BARAT','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '26','nama' => 'BALI','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '27','nama' => 'NUSA TENGGARA TIMUR','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '28','nama' => 'MALUKU','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '29','nama' => 'PAPUA','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '3','nama' => 'DKI JAKARTA','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '30','nama' => 'MALUKU UTARA','user' => '1','created_at' => '2010-03-21 20:07:54'),
            array('id' => '4','nama' => 'D.I. YOGYAKARTA','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '5','nama' => 'JAWA TENGAH','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '6','nama' => 'JAWA TIMUR','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '7','nama' => 'BENGKULU','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '8','nama' => 'JAMBI','user' => '1','created_at' => '2010-03-21 20:07:53'),
            array('id' => '9','nama' => 'NANGGROE ACEH DARUSSALAM','user' => '1','created_at' => '2010-03-21 20:07:53')
        );

        Capsule::table('propinsi')->insert($propinsi);
    }
}

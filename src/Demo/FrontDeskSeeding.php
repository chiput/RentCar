<?php
namespace App\Demo;
use Illuminate\Database\Capsule\Manager as Capsule;

class FrontDeskSeeding
{
   public function run($callerContext)
   {

        //tabel  guests (Tamu)
        $table = 'guests';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                    array('id' => '1','name' => 'Rival','address' => 'Denpasar','country_id' => '1','idcode' => '','state' => '','city' => '','zipcode' => '','phone' => '','fax' => '','email' => '','company_id' => '-- Pilih Perusahaan --','sex' => '1','date_of_birth' => '2009-01-29','date_of_validation' => '2017-03-11','idtype_id' => '3','is_active' => '1','is_blacklist' => '0','users_id' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:44:23','updated_at' => '2017-03-11 11:44:23')
                    );
            Capsule::table($table)->insert($seed);
        }

        //tabel  addchargetypes (Jenis Biaya tambahan)
        $table = 'addchargetypes';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                                array('id' => '1','code' => 'B-01','name' => 'Telepon','accincome' => '1','acccost' => '1','sell' => '200','buy' => '200','remark' => '','is_active' => '0','is_editable' => '1','users_id' => '1','created_at' => '2017-03-11 11:46:18','updated_at' => NULL)
                            );
            Capsule::table($table)->insert($seed);
        }
   }
     
}
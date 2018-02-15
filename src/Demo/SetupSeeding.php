<?php
namespace App\Demo;
use Illuminate\Database\Capsule\Manager as Capsule;

class SetupSeeding
{
   public function run($callerContext)
   {

        //tabel  companies (perusahaan)
        $table = 'companies';
       if(Capsule::schema()->hasTable($table))
        {
            $seed = [['id' => '1','name' => 'PT. Harmoni Permata','discount' => '0','is_active' => '0','users_id' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 10:45:51','updated_at' => '2017-03-11 10:45:51']];
            Capsule::table($table)->insert($seed);
        }

        //table buildings (gedung)
        $table = 'buildings';
        if(Capsule::schema()->hasTable('buildings'))
        {
            $seed = array(
                array('id' => '1','name' => 'Gedung Utara','desc' => '','users_id' => '1','created_at' => '2017-03-11 10:50:14','updated_at' => NULL,'deleted_at' => NULL),
                array('id' => '2','name' => 'Gedung Timur','desc' => '','users_id' => '1','created_at' => '2017-03-11 10:50:23','updated_at' => NULL,'deleted_at' => NULL)
            );
            Capsule::table($table)->insert($seed);
        }

        //table bed_types (jenis tempat tidur)
        $table = 'bed_types';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                array('id' => '1','name' => 'King Size','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 10:52:48','updated_at' => '2017-03-11 10:53:18')
            );
            Capsule::table($table)->insert($seed);
        }

        //table room_facilities (fasilitas kamar)
        $table = 'room_facilities';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                array('id' => '1','name' => 'TV','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 10:59:45','updated_at' => '2017-03-11 10:59:45')
            );
            Capsule::table($table)->insert($seed);
        }

        //table  room_descriptions (deskripsi kamar)
        $table = 'room_descriptions';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                array('id' => '1','name' => 'Depan Kolam','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:01:31','updated_at' => '2017-03-11 11:01:31')
            );
            Capsule::table($table)->insert($seed);
        }
        
        //table  room_types (Jenis kamar)
        $table = 'room_types';
        if(Capsule::schema()->hasTable($table))
        {

            $seed = array(
                array('id' => '1','name' => 'Deluxe','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:03:39','updated_at' => '2017-03-11 11:03:39'),
                array('id' => '2','name' => 'Presidential Suite','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:04:18','updated_at' => '2017-03-11 11:04:18')
            );
            Capsule::table($table)->insert($seed);
        }

        //table  rooms (kamar)
        $table = 'rooms';
        if(Capsule::schema()->hasTable($table))
        {

            $seed = array(
                array('id' => '1','number' => 'A-01','adults' => '2','children' => '0','buildings_id' => '1','level' => '1','room_type_id' => '1','bed_type_id' => '1','currency' => '1','note' => '','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:06:26','updated_at' => '2017-03-11 11:06:26'),
                array('id' => '2','number' => 'B-01','adults' => '2','children' => '0','buildings_id' => '1','level' => '1','room_type_id' => '2','bed_type_id' => '1','currency' => '1','note' => '','is_active' => '1','deleted_at' => NULL,'created_at' => '2017-03-11 11:06:44','updated_at' => '2017-03-11 11:06:52')
            );
            Capsule::table($table)->insert($seed);
        }

        //table  room_rel_description (relasi kamar & deskripsi)
        $table = 'room_rel_description';
        if(Capsule::schema()->hasTable($table))
        {

            $seed = array(
                array('id' => '1','room_id' => '1','room_description_id' => '1')
            );
            Capsule::table($table)->insert($seed);
        }

        //table  room_rel_facility (relasi kamar & fasilitas)
        $table = 'room_rel_facility';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                array('id' => '2','room_id' => '2','room_facility_id' => '1','created_at' => '2017-03-11 11:06:52','updated_at' => '2017-03-11 11:06:52')
            );
            Capsule::table($table)->insert($seed);
        }


        //table  room_rates (harga kamar)
        $table = 'room_rates';
        if(Capsule::schema()->hasTable($table))
        {
            $seed = array(
                array('id' => '1','room_id' => '1','dayname_id' => '1','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '2','room_id' => '1','dayname_id' => '2','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '3','room_id' => '1','dayname_id' => '3','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '4','room_id' => '1','dayname_id' => '4','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '5','room_id' => '1','dayname_id' => '5','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '6','room_id' => '1','dayname_id' => '6','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '7','room_id' => '1','dayname_id' => '7','room_price' => '400000','room_only_price' => '300000','breakfast_price' => '100000','created_at' => '2017-03-11 11:25:06','updated_at' => '2017-03-11 11:25:06'),
                array('id' => '8','room_id' => '2','dayname_id' => '1','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '9','room_id' => '2','dayname_id' => '2','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '10','room_id' => '2','dayname_id' => '3','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '11','room_id' => '2','dayname_id' => '4','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '12','room_id' => '2','dayname_id' => '5','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '13','room_id' => '2','dayname_id' => '6','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13'),
                array('id' => '14','room_id' => '2','dayname_id' => '7','room_price' => '2150000','room_only_price' => '2000000','breakfast_price' => '150000','created_at' => '2017-03-11 11:26:13','updated_at' => '2017-03-11 11:26:13')
            );
            Capsule::table($table)->insert($seed);
        }
   }
     
}
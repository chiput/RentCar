<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use App\Model\Option;

class optionMigration
{
	public function createTable ()
    {
        if(!Capsule::schema()->hasTable('options'))
        {
            Capsule::schema()->create('options', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name', 20)->nulable();
                $table->string('value', 256)->nulable();
                $table->integer('users_id');
                $table->timestamps();
                $table->softDeletes();
            });

            $this->seed();
        }  

        //mengiputkan data yang belum ada di tabel
        $check = Capsule::select("select * from options where name = 'profile_city'");

        if (count($check) <= 0) {
        	Capsule::insert("INSERT into options value ('','profile_city','Denpasar','1','2016-12-14 16:46:09', NULL,NULL)");
        }

        $check = Capsule::select("select * from options where name = 'pend_spa'");

        if (count($check) <= 0) {
        	Capsule::insert("INSERT into options value ('','pend_spa','','0','2016-12-14 16:46:09', NULL,NULL)");
        }

        $check = Capsule::select("select * from options where name = 'pend_restoranwh'");

        if (count($check) <= 0) {
        	Capsule::insert("INSERT into options value ('','pend_restoranwh','','0','2016-12-14 16:46:09', NULL,NULL)");
        }

        $check = Capsule::select("select * from options where name = 'pend_store'");

        if (count($check) <= 0) {
        	Capsule::insert("INSERT into options value ('','pend_store','','0','2017-09-14 15:21:09', NULL,NULL)");
        }

    }

    public function seed()
    {
    	// kulkul_hos.options
    	$options = array(
					  array('name' => 'kas','value' => '1','users_id' => '0','created_at' => '2016-12-14 16:46:09','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pot_penj','value' => '','users_id' => '0','created_at' => '2016-12-30 09:53:47','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pot_pemb','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'piutang','value' => '4','users_id' => '0','created_at' => '2016-12-14 16:47:10','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'hutang','value' => '13','users_id' => '0','created_at' => '2016-12-14 16:46:09','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pembulatan','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'nominal','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'giro_masuk','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'giro_keluar','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'laba','value' => '24','users_id' => '0','created_at' => '2016-12-14 16:47:10','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'modal','value' => '15','users_id' => '0','created_at' => '2016-12-14 16:47:10','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'persediaan','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'penjualan','value' => '29','users_id' => '0','created_at' => '2016-12-15 09:49:07','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'hpp','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'ppn_jual','value' => '30','users_id' => '0','created_at' => '2016-12-15 09:49:07','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'ppn_beli','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'kas_bon','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'gaji','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_parkir','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'voucher','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'service','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'barang_hilang','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'revisi_stok','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'deposit','value' => '17','users_id' => '0','created_at' => '2017-01-03 13:58:34','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'biaya_laundry','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'biaya_barang_rusak','value' => '1','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_hotel','value' => '17','users_id' => '0','created_at' => '2016-12-14 16:47:10','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_restoran','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_restoranwh','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_spa','value' => '','users_id' => '0','created_at' => '2016-12-14 16:46:09','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_spa','value' => '','users_id' => '0','created_at' => '2016-12-14 16:46:09','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_laundry','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_karaoke','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_sewa_brg','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'pend_service','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'b_diskon','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'fee','value' => '1','users_id' => '0','created_at' => '2016-12-14 16:46:09','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'o_kirim_pembelian','value' => '','users_id' => '0','created_at' => '2016-12-14 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'beban_pembelian','value' => '','users_id' => '0','created_at' => '2017-04-08 12:36:20','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_name','value' => 'Hotel Kumala Pantai','users_id' => '0','created_at' => '2016-12-14 22:32:18','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_address','value' => 'Jl. Werkudara, Legian Kaja, Kuta Bali 80361 Indonesia ','users_id' => '0','created_at' => '2016-12-14 22:39:21','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_phone','value' => '+62 361 755500','users_id' => '1','created_at' => '2016-12-14 22:40:18','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_fax','value' => '+62 361 755700','users_id' => '1','created_at' => '2016-12-14 22:40:18','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_website','value' => 'www.kumalapantai.com','users_id' => '1','created_at' => '2016-12-14 22:40:18','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_email','value' => 'info@kumalapantai.com','users_id' => '1','created_at' => '2016-12-14 22:40:18','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_logo','value' => 'logo.png','users_id' => '1','created_at' => '2017-01-26 19:14:22','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'profile_city','value' => 'Denpasar','users_id' => '1','created_at' => '2016-12-14 22:39:21','updated_at' => NULL,'deleted_at' => NULL),
					  array('name' => 'key','value' => '','users_id' => '1','created_at' => '2016-12-14 22:39:21','updated_at' => NULL,'deleted_at' => NULL)

					  );
					
		Capsule::table('options')->insert($options);
    }
}
<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccountsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accounts'))
        {
            Capsule::schema()->create('accounts', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('accheaders_id')->default(0);
                $table->string('accheaders_code')->default('');
                $table->string('type');
                $table->integer('kas')->default(0);
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'))->nullable();
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });

            $accounts = array(
                        array('id' => '1','code' => '100-01','name' => 'Kas Kecil','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '2','code' => '101-01','name' => 'Bank BCA ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '3','code' => '101-02','name' => 'Bank BRI ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '4','code' => '102-01 ','name' => 'Piutang ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '5','code' => '104-01','name' => 'Perlengkapan ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '6','code' => '121-01','name' => 'Tanah ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '7','code' => '122-01','name' => 'Gedung','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '8','code' => '123-01','name' => 'Akumulasi Penyusutan Gedung ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '9','code' => '124-01','name' => 'Peralatan Kantor ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '10','code' => '125-01','name' => 'Peralatan ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => '2016-12-13 16:24:23'),
                        array('id' => '13','code' => '211-01','name' => 'Utang usaha','accheaders_id' => '7','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '14','code' => '212-01','name' => 'Sewa yang masih harus dibayar','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '15','code' => '300-01','name' => 'Modal','accheaders_id' => '33','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '16','code' => '301-01','name' => 'Prive ','accheaders_id' => '33','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '17','code' => '400-01','name' => 'Pendapatan Sewa Kamar','accheaders_id' => '10','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '18','code' => '401-01','name' => 'Pendapatan Bunga Bank','accheaders_id' => '11','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '20','code' => '213-01','name' => 'Hutang Gaji','accheaders_id' => '33','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '21','code' => '501-01','name' => 'Beban Gaji ','accheaders_id' => '34','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '22','code' => '502-01','name' => 'Beban Operasional','accheaders_id' => '34','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '23','code' => '503-01','name' => 'Beban Penjualan ','accheaders_id' => '34','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '24','code' => '126-01','name' => 'Laba Ditahan','accheaders_id' => '1','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '25','code' => '150-01','name' => 'Inventory','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '26','code' => '160-01','name' => 'Akumulasi Depresiasi Gedung ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '27','code' => '160-02','name' => 'Akumulasi Depresiasi Kendaraan ','accheaders_id' => '1','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '28','code' => '500-01','name' => 'Potongan Pembelian ','accheaders_id' => '1','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '29','code' => '400-00','name' => 'Penjualan ','accheaders_id' => '10','accheaders_code' => '','type' => 'Kredit','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '30','code' => '402-01','name' => 'Potongan Penjualan ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '31','code' => '127-01','name' => 'Kendaraan','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '32','code' => '123-02','name' => 'Akum. Pnyt. Kendaraan ','accheaders_id' => '1','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '33','code' => '504-01','name' => 'Beban Administrasi ','accheaders_id' => '34','accheaders_code' => '','type' => 'Debet','kas' => '0','users_id' => '1','created_at' => NULL,'updated_at' => NULL,'deleted_at' => NULL),
                        array('id' => '34', 'code' => '01', 'name' => 'Pajak Pembelian', 'accheaders_id' => '32', 'accheaders_code' => '', 
                            'type' => 'Debet', 'kas' => '0', 'users_id' => '1', 'created_at' => '2017-04-08 07:09:12', 'updated_at' => NULL, 'deleted_at' => NULL),
                        array('id' => '35', 'code' => '02', 'name' => 'Pajak Penjualan', 'accheaders_id' => '32', 'accheaders_code' => '','type' => 'Kredit', 'kas' => '0', 'users_id' => '1', 'created_at' => '2017-04-08 07:09:44', 'updated_at' => NULL, 'deleted_at' => NULL),
                        array('id' => '36', 'code' => '400-02', 'name' => 'Pendapatan Restoran', 'accheaders_id' => '12', 'accheaders_code' => '', 'type' => 'Kredit', 'kas' => '0', 'users_id' => '1', 'created_at' => '2017-04-08 07:14:05', 'updated_at' => NULL,     'deleted_at' => NULL),
                        array('id' => '37', 'code' => '501-02', 'name' => 'Beban Pembelian', 'accheaders_id' => '34', 'accheaders_code' => '',  'type' => 'Kredit', 'kas' => '0', 'users_id' => '1', 'created_at' => '2017-04-08 07:16:23', 'updated_at' => NULL, 'deleted_at' => NULL),
                        array('id' => 38, 'code' => '501-03', 'name' => 'Beban Pengiriman Barang', 'accheaders_id' => '34', 'accheaders_code' => '', 'type' => 'Debet', 'kas' => '0', 'users_id' => '1', 'created_at' => '2017-04-08 07:17:47', 'updated_at' => NULL, 'deleted_at' => NULL)
                        );

            Capsule::table("accounts")->insert($accounts);

        }
    }
}

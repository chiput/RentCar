<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ResourceMigration
{
    public function createTable ()
    {
        //if(!Capsule::schema()->hasTable('resources'))
        //{
            Capsule::schema()->dropIfExists('resources');

            Capsule::schema()->create('resources', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('resource_category_id');
                $table->string('name');
                $table->integer('sequence');
                $table->timestamps();
            });

            $resources = array(
                array('id' => '1','resource_category_id' => '1','name' => 'accounts','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '2','resource_category_id' => '1','name' => 'headers','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '3','resource_category_id' => '1','name' => 'jurnal','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '4','resource_category_id' => '1','name' => 'neraca','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '5','resource_category_id' => '1','name' => 'tipe kas','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '6','resource_category_id' => '1','name' => 'kas & bank','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '7','resource_category_id' => '1','name' => 'matauang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '8','resource_category_id' => '1','name' => 'report','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '9','resource_category_id' => '1','name' => 'aktiva','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '10','resource_category_id' => '1','name' => 'aktiva-group','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '11','resource_category_id' => '2','name' => 'departemen','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '12','resource_category_id' => '2','name' => 'user','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '13','resource_category_id' => '2','name' => 'kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '14','resource_category_id' => '2','name' => 'fasilitas kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '15','resource_category_id' => '2','name' => 'deskripsi kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '16','resource_category_id' => '2','name' => 'tipe tempat tidur','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '17','resource_category_id' => '2','name' => 'kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '18','resource_category_id' => '2','name' => 'harga kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '19','resource_category_id' => '2','name' => 'harga kamar periodik','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '20','resource_category_id' => '2','name' => 'option','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '21','resource_category_id' => '3','name' => 'tamu','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '22','resource_category_id' => '3','name' => 'agen','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '23','resource_category_id' => '3','name' => 'reservasi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '24','resource_category_id' => '3','name' => 'jenis biaya tambahan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '25','resource_category_id' => '3','name' => 'biaya tambahan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '26','resource_category_id' => '3','name' => 'deposit','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '27','resource_category_id' => '3','name' => 'checkin','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '28','resource_category_id' => '3','name' => 'checkin-group','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '29','resource_category_id' => '3','name' => 'checkout','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '30','resource_category_id' => '3','name' => 'status kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '31','resource_category_id' => '4','name' => 'laundry-tarif','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '32','resource_category_id' => '4','name' => 'laundry-layanan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '33','resource_category_id' => '4','name' => 'barang-temuan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '34','resource_category_id' => '4','name' => 'barang-hilang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '35','resource_category_id' => '4','name' => 'barang-kembali','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '36','resource_category_id' => '4','name' => 'room-service ','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '37','resource_category_id' => '4','name' => 'pinjam-barang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '38','resource_category_id' => '4','name' => 'jenis-barang-pinjam','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '39','resource_category_id' => '5','name' => 'menu','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '40','resource_category_id' => '5','name' => 'menukategori','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '41','resource_category_id' => '5','name' => 'statusmeja','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '42','resource_category_id' => '5','name' => 'kasir','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '43','resource_category_id' => '5','name' => 'gudang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '44','resource_category_id' => '5','name' => 'meja','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '45','resource_category_id' => '5','name' => 'pelanggan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '46','resource_category_id' => '5','name' => 'report','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '47','resource_category_id' => '5','name' => 'pesanan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '48','resource_category_id' => '6','name' => 'supplier','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '49','resource_category_id' => '6','name' => 'pembelian','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '50','resource_category_id' => '6','name' => 'retur pembelian','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '51','resource_category_id' => '6','name' => 'report','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '52','resource_category_id' => '7','name' => 'gudang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '53','resource_category_id' => '7','name' => 'barang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '54','resource_category_id' => '7','name' => 'konversi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '55','resource_category_id' => '7','name' => 'kategori','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '56','resource_category_id' => '7','name' => 'satuan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '57','resource_category_id' => '7','name' => 'barang hilang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '58','resource_category_id' => '7','name' => 'permintaan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '59','resource_category_id' => '7','name' => 'pemakaian','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '60','resource_category_id' => '7','name' => 'mutasi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '61','resource_category_id' => '7','name' => 'opname','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '62','resource_category_id' => '7','name' => 'laporan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '63','resource_category_id' => '7','name' => 'revisi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '64','resource_category_id' => '7','name' => 'penerimaan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '65','resource_category_id' => '7','name' => 'barcode','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '66','resource_category_id' => '2','name' => 'perusahaan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '67','resource_category_id' => '2','name' => 'gedung','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '68','resource_category_id' => '1','name' => 'Bank','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '69','resource_category_id' => '1','name' => 'Kartu Kredit','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '70','resource_category_id' => '1','name' => 'Pendapatan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '71','resource_category_id' => '8','name' => 'Kasir','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '72','resource_category_id' => '8','name' => 'Kategori Layanan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '73','resource_category_id' => '8','name' => 'Layanan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '74','resource_category_id' => '8','name' => 'Terapis','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '75','resource_category_id' => '8','name' => 'Gudang Spa','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '76','resource_category_id' => '8','name' => 'Laporan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '77','resource_category_id' => '9','name' => 'Analisa Kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '78','resource_category_id' => '9','name' => 'Agent Sales','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '79','resource_category_id' => '9','name' => 'Tarif Telepon','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '80','resource_category_id' => '9','name' => 'Ekstention Telepon','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '81','resource_category_id' => '9','name' => 'Billing Telepon','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '82','resource_category_id' => '10','name' => 'Barang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '83','resource_category_id' => '10','name' => 'Kasir','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '84','resource_category_id' => '10','name' => 'Gudang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '85','resource_category_id' => '10','name' => 'Laporan Penjualan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),

                //add resource action other(tambahan menu)
                    //front desk
                array('id' => '86','resource_category_id' => '3','name' => 'Laporan Tamu','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '87','resource_category_id' => '3','name' => 'Pindah Kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '88','resource_category_id' => '3','name' => 'Reservation Chart','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '89','resource_category_id' => '3','name' => 'Phone Book','sequence' => '0','created_at' => NULL,'updated_at' => NULL),           
                array('id' => '90','resource_category_id' => '3','name' => 'Laporan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //housekeeping         
                array('id' => '91','resource_category_id' => '4','name' => 'Setting Status Kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '92','resource_category_id' => '4','name' => 'Laporan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //restaurant
                array('id' => '93','resource_category_id' => '5','name' => 'Restorante Italia','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '94','resource_category_id' => '5','name' => 'Kasir Restorante Italia','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '95','resource_category_id' => '5','name' => 'White Horse','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '96','resource_category_id' => '5','name' => 'Kasir Whie Horse','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '97','resource_category_id' => '5','name' => 'Waiters','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '98','resource_category_id' => '5','name' => 'Laporan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //setup
                array('id' => '99','resource_category_id' => '2','name' => 'Setup Perusahaan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '100','resource_category_id' => '2','name' => 'Jenis Status Kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '101','resource_category_id' => '2','name' => 'Deskripsi Kamar','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //accounting laba rugi
                array('id' => '102','resource_category_id' => '1','name' => 'Pengeluaran','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '103','resource_category_id' => '1','name' => 'Laba Rugi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //Logistik - Request Barang
                array('id' => '104','resource_category_id' => '7','name' => 'Permintaan Barang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //Management
                array('id' => '105','resource_category_id' => '9','name' => 'Restorant','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '106','resource_category_id' => '9','name' => 'Tamu','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '107','resource_category_id' => '9','name' => 'Spa','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '109','resource_category_id' => '9','name' => 'Store','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                    //jobdesc
                array('id' => '108','resource_category_id' => '9','name' => 'Jobdesc','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '110','resource_category_id' => '9','name' => 'Analisa Keuangan','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '111','resource_category_id' => '9','name' => 'Analisa Reservasi','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                array('id' => '112','resource_category_id' => '9','name' => 'Analisa Checkin','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                //setup
                array('id' => '113','resource_category_id' => '2','name' => 'Setup Gudang','sequence' => '0','created_at' => NULL,'updated_at' => NULL),
                );

            Capsule::table('resources')->insert($resources);
        //}
    }
}

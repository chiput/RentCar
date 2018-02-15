<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccheadersMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accheaders'))
        {
            Capsule::schema()->create('accheaders', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code');
                $table->string('name');
                $table->integer('accgroups_id')->default(0);
                $table->string('remark')->default("");
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

            $accheaders = array(
                            array('id' => '1','code' => '100','name' => 'AKTIVA','accgroups_id' => '1','remark' => '','users_id' => '1'),
                            array('id' => '2','code' => '110','name' => 'BANK','accgroups_id' => '1','remark' => '','users_id' => '1'),
                            array('id' => '3','code' => '120','name' => 'PERSEDIAAN','accgroups_id' => '1','remark' => '','users_id' => '1'),
                            array('id' => '4','code' => '150','name' => 'PIUTANG USAHA','accgroups_id' => '1','remark' => '','users_id' => '1'),
                            array('id' => '5','code' => '200','name' => 'PERLENGKAPAN','accgroups_id' => '2','remark' => '','users_id' => '1'),
                            array('id' => '6','code' => '301','name' => 'AKTIVA LAIN LAIN','accgroups_id' => '3','remark' => '','users_id' => '1'),
                            array('id' => '7','code' => '500','name' => 'HUTANG LANCAR','accgroups_id' => '4','remark' => '','users_id' => '1'),
                            array('id' => '8','code' => '700','name' => 'PENDAPATAN UNIT SERBA USAHA','accgroups_id' => '7','remark' => '','users_id' => '1'),
                            array('id' => '9','code' => '701','name' => 'PENDAPATAN UNIT TOKO','accgroups_id' => '7','remark' => '','users_id' => '1'),
                            array('id' => '10','code' => '702','name' => 'PENDAPATAN USAHA LAIN','accgroups_id' => '7','remark' => '','users_id' => '1'),
                            array('id' => '11','code' => '703','name' => 'PENDAPATAN DILUAR USAHA','accgroups_id' => '7','remark' => '','users_id' => '1'),
                            array('id' => '12','code' => '704','name' => 'PENDAPATAN RESTORAN','accgroups_id' => '7','remark' => '','users_id' => '1'),
                            array('id' => '13','code' => '800','name' => 'MODAL','accgroups_id' => '6','remark' => '','users_id' => '1'),
                            array('id' => '14','code' => '850','name' => 'HARGA POKOK UNIT PENJUALAN','accgroups_id' => '8','remark' => '','users_id' => '1'),
                            array('id' => '15','code' => '860','name' => 'BIAYA OPERASIONAL','accgroups_id' => '9','remark' => '','users_id' => '1'),
                            array('id' => '16','code' => '861','name' => 'BIAYA ORGANISASI','accgroups_id' => '9','remark' => '','users_id' => '1'),
                            array('id' => '17','code' => '862','name' => 'BIAYA ADM. DAN UMUM','accgroups_id' => '9','remark' => '','users_id' => '1'),
                            array('id' => '18','code' => '863','name' => 'BIAYA LAIN LAIN','accgroups_id' => '9','remark' => '','users_id' => '1'),
                            array('id' => '19','code' => '888','name' => 'tes','accgroups_id' => '6','remark' => 'asd','users_id' => '1'),
                            array('id' => '20','code' => '00011','name' => 'aktia lancar','accgroups_id' => '1','remark' => '','users_id' => '1'),
                            array('id' => '21','code' => '10001','name' => 'Mobil','accgroups_id' => '1','remark' => 'kendaraan kantor','users_id' => '1'),
                            array('id' => '22','code' => '100-0001','name' => 'Kendaraan','accgroups_id' => '2','remark' => '','users_id' => '1'),
                            array('id' => '23','code' => '100-0001','name' => 'kas kecil','accgroups_id' => '2','remark' => '','users_id' => '1'),
                            array('id' => '24','code' => '000113','name' => 'Perlengkapan','accgroups_id' => '1','remark' => 'Perlengkapan ','users_id' => '1'),
                            array('id' => '25','code' => '12.0098','name' => 'KAS TERSISA','accgroups_id' => '1','remark' => 'n/a','users_id' => '1'),
                            array('id' => '26','code' => '12.0010','name' => 'GEDUNG RESTAURANT 2','accgroups_id' => '2','remark' => 'n/a','users_id' => '1'),
                            array('id' => '27','code' => '12.0011','name' => 'MESIN BELUM DIGUNAKAN','accgroups_id' => '3','remark' => 'n/a','users_id' => '1'),
                            array('id' => '28','code' => '12.0012','name' => 'HUTANG BANK','accgroups_id' => '4','remark' => 'n/a','users_id' => '1'),
                            array('id' => '29','code' => '12.0013','name' => 'HUTANG KREDITUR','accgroups_id' => '5','remark' => 'n/a','users_id' => '1'),
                            array('id' => '30','code' => '12.0014','name' => 'MODAL','accgroups_id' => '6','remark' => 'n/a','users_id' => '1'),
                            array('id' => '31','code' => '12.0015','name' => 'PENDAPATAN','accgroups_id' => '7','remark' => 'n/a','users_id' => '1'),
                            array('id' => '32','code' => '12.0016','name' => 'BIAYA','accgroups_id' => '9','remark' => 'n/a','users_id' => '1'),
                            array('id' => '33','code' => '300-00','name' => 'Ekuitas ','accgroups_id' => '6','remark' => '','users_id' => '1'),
                            array('id' => '34','code' => '500-00','name' => 'Biaya - biaya ','accgroups_id' => '9','remark' => '','users_id' => '1')
                            );

            Capsule::table("accheaders")->insert($accheaders);

        }
    }
}

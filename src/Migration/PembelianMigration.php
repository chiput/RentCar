<?php
namespace App\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PembelianMigration
{
    public function createTable()
    {
        if(!Capsule::schema()->hasTable('pembelian'))
        {
            Capsule::schema()->create('pembelian', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti', 30);
                $table->integer('supplier_id');
                $table->integer('department_id');
                $table->integer('permintaan_id');
                $table->double('diskon', 15,2);
                $table->double('ppn', 9,2);
                $table->double('ongkos', 15,2);
                $table->double('tempo', 15,2);
                $table->string('keterangan', 300);
                $table->char('tunai', 1);
                $table->string('jurnalid')->nullable();
                $table->char('cetak', 1);
                $table->integer('users_id');
                $table->integer('users_id_edit');
                $table->timestamps();
                $table->softDeletes();
            });
        }

        Capsule::schema()->table('pembelian', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
    public function seedTable()
    {
    }
}
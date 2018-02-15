<?php
namespace App\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PembelianStatusMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('pembelianstatus'))
		{
			Capsule::schema()->create('pembelianstatus', function (Blueprint $table)
			{
				$table->increments('id');
				$table->date('tanggal');
				$table->integer('pembelian_id');
				$table->string('keterangan');
				$table->string('status');
                $table->timestamps();
			});
		}
	}
}
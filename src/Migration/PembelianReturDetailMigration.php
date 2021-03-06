<?php
namespace App\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PembelianReturDetailMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('pembelianreturdetail'))
		{
			Capsule::schema()->create('pembelianreturdetail', function (Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pembelianretur_id');
				$table->integer('barang_id');
				$table->integer('satuan_id');
				$table->double('kuantitas', 9,2);
				$table->double('harga', 15,2);
                $table->timestamps();
			});
		}
	}
}
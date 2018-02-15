<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class PembelianReturMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('pembelianretur'))
		{
			Capsule::schema()->create('pembelianretur', function(Blueprint $table)
			{
				$table->increments('id');
				$table->date('tanggal');
				$table->string('nobukti', 30);
				$table->integer('pembelian_id');
				$table->integer('terima_id');
				$table->integer('accjurnals_id')->nullable();
				$table->string('keterangan');
				$table->char('cetak', 1)->nullable();
				$table->integer('users_id');
				$table->integer('users_id_edit');
				$table->timestamps();
                $table->softDeletes();
			});
		}

		Capsule::schema()->table('pembelianretur', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
	}
}
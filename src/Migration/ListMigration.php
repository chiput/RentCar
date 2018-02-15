<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ListMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('lists')) {
			Capsule::schema()->create('lists', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('board');
					$table->string('listname', 50);
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BoardMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('boards')) {
			Capsule::schema()->create('boards', function(Blueprint $table)
				{
					$table->increments('id');
					$table->string('user_id', 50);
					$table->string('boardname', 50);
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
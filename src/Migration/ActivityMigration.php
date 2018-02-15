<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ActivityMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('activities')) {
			Capsule::schema()->create('activities', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('user_id');
					$table->integer('board_id');
					$table->integer('list_id');
					$table->integer('card_id');
					$table->string('ket', 125);
					$table->integer('comment');
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
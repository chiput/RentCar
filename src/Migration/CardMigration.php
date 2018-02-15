<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CardMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('cards')) {
			Capsule::schema()->create('cards', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('list');
					$table->string('cardname', 100);
					$table->text('description');
					$table->text('attachment');
					$table->time('duetime');
					$table->date('duedate');
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
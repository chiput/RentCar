<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ChecklistMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('checklists')) {
			Capsule::schema()->create('checklists', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('card_id');
					$table->string('checklistname', 100);
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
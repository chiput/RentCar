<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ChildlistMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('childlists')) {
			Capsule::schema()->create('childlists', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('checklist_id');
					$table->string('childname', 50);
					$table->integer('status');
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
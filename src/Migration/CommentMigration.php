<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CommentMigration
{
	public function createTable()
	{
		if(!Capsule::schema()->hasTable('comments')) {
			Capsule::schema()->create('comments', function(Blueprint $table)
				{
					$table->increments('id');
					$table->integer('card_id');
					$table->integer('user_id');
					$table->text('comment');
					$table->timestamps();
					$table->softDeletes();
				});
		}
	}
}
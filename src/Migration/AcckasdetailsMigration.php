<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AcckasdetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('acckasdetails'))
        {
            Capsule::schema()->create('acckasdetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('acckas_id')->default(0);
                $table->integer('acckastypes_id')->default(0);
                $table->string('remark');
                $table->double('nominal');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });
            
        }
    }
}

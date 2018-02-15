<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AddchargedetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('addchargedetails'))
        {
            Capsule::schema()->create('addchargedetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('addcharges_id')->default(0);
                $table->integer('addchargetypes_id')->default(0);
                $table->integer('accjurnals_id')->default(0);
                $table->string('remark')->default('');
                $table->integer('qty')->default(0);
                $table->double('sell')->default(0);
                $table->double('buy')->default(0);
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
    }
}
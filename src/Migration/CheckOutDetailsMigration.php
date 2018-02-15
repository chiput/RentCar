<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CheckOutDetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('check_out_details'))
        {
            Capsule::schema()->create('check_out_details', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('check_out_id');
                $table->integer('reservation_detail_id');
                $table->timestamp('checkout_time');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });

        }
    }
}

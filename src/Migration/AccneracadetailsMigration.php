<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccneracadetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accneracadetails'))
        {
            Capsule::schema()->create('accneracadetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('accneracas_id');
                $table->integer('accounts_id')->default(0);
                $table->double('debet')->default(0);
                $table->double('kredit')->default(0);
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });
            
        }
    }
}

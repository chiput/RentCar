<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccneracasMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accneracas'))
        {
            Capsule::schema()->create('accneracas', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('type')->default('CLOSING');
                $table->integer('users_id');
                $table->integer('accjurnals_id')->default(0);
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });
        }
        
        if(!Capsule::schema()->hasColumn('accneracas', 'accjurnals_id')){
            Capsule::schema()->table('accneracas', function (Blueprint $table) {
                $table->integer('accjurnals_id')->default(0);
            });
        } elseif (!Capsule::schema()->hasColumn('accneracas','users_id_edit')) {
            Capsule::schema()->table('accneracas', function(Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id');
            });
        }

        Capsule::schema()->table('accneracas', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

 
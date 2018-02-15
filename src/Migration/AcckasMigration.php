<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AcckasMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('acckas'))
        {
            Capsule::schema()->create('acckas', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->string('nobukti')->nullable();
                $table->string('penyetor')->default('');
                $table->string('penerima')->default('');
                $table->string('remark')->default('');
                $table->integer('accjurnals_id');
                $table->string('type')->default('');
                $table->string('cetak')->default('');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();

            });
            
        } if (!Capsule::schema()->hasColumn('acckas','users_id_edit')) {
            Capsule::schema()->table('acckas', function(Blueprint $table) {
                $table->integer('users_id_edit')->after('users_id');
            });
        }

        Capsule::schema()->table('acckas', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        }); 
    }
}

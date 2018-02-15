<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccjurnalsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accjurnals'))
        {
            Capsule::schema()->create('accjurnals', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('code')->nullable();
                $table->date('tanggal');
                $table->string('nobukti')->nullable();
                $table->string('keterangan')->default('');
                $table->string('automated')->nullable();
                $table->string('posted')->default('UNPOSTED');
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });
            
        }
    }
}
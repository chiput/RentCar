<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class AccjurnaldetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('accjurnaldetails'))
        {
            Capsule::schema()->create('accjurnaldetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('accjurnals_id');
                $table->integer('accounts_id');
                $table->string('keterangan')->default('');
                $table->double('debet')->default(0);
                $table->double('kredit')->default(0);
                $table->string('cek')->default('');
                $table->integer('users_id')->default(1);
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
            });
            
        }
    }
}

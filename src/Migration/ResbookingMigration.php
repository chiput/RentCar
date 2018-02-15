<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ResbookingMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('resbooking'))
        {
            Capsule::schema()->create('resbooking', function (Blueprint $table)
            {
                $table->increments('id');
                $table->date('tanggal');
                $table->date('checkin');
                $table->time('jam');
                $table->string('nobukti');
                $table->integer('pax')->default(0);
                $table->integer('meja_id')->nullable();
                $table->integer('pelanggan_id')->nullable();
                $table->integer('rooms_id')->nullable();
                $table->integer('status')->default(0); //'0 booking, 1 checkin, 2 cancel',
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });
        }
        if(!Capsule::Schema()->hasColumn('resbooking','users_id_edit')) {
            Capsule::Schema()->table('resbooking', function($table)
            {
                $table->integer('users_id_edit')->nullable()->after('users_id');
            });
        }
    }
}

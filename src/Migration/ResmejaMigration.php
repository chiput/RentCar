<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ResmejaMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('resmeja'))
        {
            Capsule::schema()->create('resmeja', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode');
                $table->string('orang');
                $table->string('keterangan');
                $table->string('users_id');
                $table->string('aktif',1)->default('1');
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if(Capsule::Schema()->hasColumn('resmeja','kode')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->renameColumn('kode', 'kode_meja');
            });
        }
        if(Capsule::Schema()->hasColumn('resmeja','orang')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->renameColumn('orang', 'max_tamu');
            });
        }
        if(!Capsule::Schema()->hasColumn('resmeja','nama_meja')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->string('nama_meja')->after('kode_meja');
            });
        }
        if(Capsule::Schema()->hasColumn('resmeja','keterangan')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->renameColumn('keterangan','tipe_meja');
            });
        }
        if(Capsule::Schema()->hasColumn('resmeja','aktif')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->dropColumn('aktif');
            });
        } 
        if(Capsule::Schema()->hasColumn('resmeja','nama_meja')) {
            Capsule::Schema()->table('resmeja', function($table)
            {
                $table->dropColumn('nama_meja');
            });
        }
    }
}

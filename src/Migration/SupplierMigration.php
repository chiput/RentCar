<?php
namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class SupplierMigration
{
    public function createTable()
    {
        if(!Capsule::schema()->hasTable('suppliers'))
        {
            Capsule::schema()->create('suppliers', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('kode', 30);
                $table->string('nama', 100);
                $table->string('contact', 100);
                $table->string('alamat', 300);
                $table->string('kotaid', 30);
                $table->string('telepon', 100);
                $table->integer('users_id');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}
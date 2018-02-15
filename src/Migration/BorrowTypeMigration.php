<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class BorrowTypeMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('hotjenispinjam'))
        {
            Capsule::schema()->create('hotjenispinjam', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('barangid');
                $table->double('kuantitas', 9, 2);
                $table->double('sewa', 15, 2);
                $table->char('aktif', 1);
                $table->string('user');
                $table->timestamps();
            });
        }
    }
}

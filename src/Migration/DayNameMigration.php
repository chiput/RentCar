<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use App\Model\DayName;

class DayNameMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('day_names'))
        {
            Capsule::schema()->create('day_names', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('number');
                $table->string('dayname');
                $table->timestamps();
            });

            $this->seed();
        }
    }

    public function seed()
    {
        $dayNames = [
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];

        foreach ($dayNames as $key => $dayName) {
            $d = new DayName();
            $d->number = $key;
            $d->dayname = $dayName;
            $d->save();
            unset($d);
        }
    }
}

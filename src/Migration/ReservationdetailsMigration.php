<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class ReservationdetailsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('reservationdetails'))
        {
            Capsule::schema()->create('reservationdetails', function (Blueprint $table)
            {
                $table->increments('id');
                $table->integer('reservations_id');
                $table->integer('rooms_id');
                $table->string('checkin_code')->nullable();
                $table->timestamp('checkin_at')->nullable();
                $table->timestamp('checkout_at')->nullable();
                $table->integer('check_out_id')->nullable();
                $table->integer('adult')->default(0);
                $table->integer('children')->default(0);
                $table->integer('creditcard_id')->default(0);
                $table->string('creditcard_number')->default('');
                $table->string('note')->default('');
                $table->string('internal_note')->default('');
                $table->integer('is_compliment')->default(0);
                $table->integer('room_changes_id')->default(0);
                $table->integer('change_code')->default(0);
                $table->double('price')->default(0);
                $table->double('priceExtra')->default(0);
                $table->double('price_old')->default(0);
                $table->double('priceExtra_old')->default(0);
                $table->integer('users_id');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        } if (!Capsule::schema()->hasColumn('reservationdetails','users_id_edit')) {
            Capsule::schema()->table('reservationdetails', function(Blueprint $table){
                $table->integer('users_id_edit')->after('users_id');
            });
        }

        Capsule::schema()->table('reservationdetails', function (Blueprint $table) {
            $table->integer('users_id_edit')->nullable()->change();
        });
    }
}

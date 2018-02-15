<?php

namespace App\Migration;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class CheckoutsMigration
{
    public function createTable ()
    {
        if(!Capsule::schema()->hasTable('check_outs'))
        {
            Capsule::schema()->create('check_outs', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('checkout_code');
                $table->date('checkout_date');
                $table->integer('guest_id');
                $table->double('subtotal');
                $table->integer('discount_percent');
                $table->double('discount');
                $table->integer('is_discount_room_only');
                $table->integer('service_percent');
                $table->double('service_charge');
                $table->integer('is_service_room_only');
                $table->integer('tax_percent');
                $table->double('tax_charge');
                $table->integer('is_tax_room_only');
                $table->double('deposit');
                $table->double('refund');
                $table->double('total');
                $table->double('cash');
                $table->integer('creditcard_id');
                $table->string('creditcard_number');
                $table->double('creditcard_amount');
                $table->double('payment_change');
                $table->integer('accjurnals_id');
                $table->integer('hiddenhrgkamar');
                $table->timestamp('created_at')->default(Capsule::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->default(Capsule::raw('NULL'))->nullable();
                $table->softDeletes();
            });

        } if (!Capsule::schema()->hasColumn('check_outs','users_id')) {
            Capsule::schema()->table('check_outs', function(Blueprint $table) {
                $table->integer('users_id')->after('hiddenhrgkamar');
            });
        }
        if(!Capsule::schema()->hasColumn('check_outs', 'remarks')){
            Capsule::schema()->table('check_outs', function (Blueprint $table) {
                $table->string('remarks')->after('accjurnals_id');
            });
        }
        Capsule::schema()->table('check_outs', function (Blueprint $table) {
            $table->integer('hiddenhrgkamar')->nullable()->change();
        }); 
    }
}
